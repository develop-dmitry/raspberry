<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\GeolocationInterface;
use Raspberry\Common\Values\Temperature\Temperature;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\HasAuthorize;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Messenger\MessengerGatewayInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\ReplyButton\SendLocationOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Weather\Application\ActualWeather\ActualWeatherInterface;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherRequest;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;

class WeatherGatewayHandler extends AbstractHandler
{
    use HasAuthorize;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        protected ActualWeatherInterface $actualWeather,
        protected LoggerInterface $logger,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @param ContextInterface $context
     * @param MessengerGatewayInterface $messenger
     * @return void
     * @throws InvalidValueException
     * @throws FailedSaveUserException
     * @throws FailedAuthorizeException
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $this->identifyUser($this->contextUser?->getMessengerId());

        if ($this->contextRequest->getGeolocation()) {
            $this->contextUser->setGeolocation($this->contextRequest->getGeolocation());
        }

        if ($geolocation = $this->contextUser->getGeolocation()) {
            try {
                $temperature = new Temperature($this->getTemperature($geolocation));
                (new SelectionLookRepository($this->userId))->setTemperature($temperature->getValue());

                $text = "Ваше местоположение {$geolocation->getDecimal()}\nТемпература {$temperature->getCelsius()}";
                $message = Message::withReplyKeyboard($text, $this->makeTemperatureMenu());
            } catch (Exception $exception) {
                $this->logger->debug('Error while execute weather gateway handler', [
                    'exception' => $exception->getMessage()
                ]);

                $message = Message::text('Не удалось получить текущую температуру, введите температуру вручную');
            }
        } else {
            $message = Message::text('Не удалось получить местоположение');
        }

        $messenger->sendMessage($message);
    }

    /**
     * @param GeolocationInterface $geolocation
     * @return int
     * @throws InvalidValueException
     * @throws WeatherGatewayException
     */
    protected function getTemperature(GeolocationInterface $geolocation): int
    {
        $request = new ActualWeatherRequest($geolocation->getLat(), $geolocation->getLon());
        $response = $this->actualWeather->execute($request);

        return $response->getTemperature();
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeTemperatureMenu(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make()
            ->addRow(
                $this->replyButtonFactory
                    ->setText(TemperatureMenu::Accept->getText())
                    ->make()
            )
            ->addRow(
                $this->replyButtonFactory
                    ->setText(TemperatureMenu::Input->getText())
                    ->make()
            )
            ->addRow(
                $this->replyButtonFactory
                    ->setText(TemperatureMenu::Gateway->getText())
                    ->setSendLocation(new SendLocationOption(true))
                    ->make()
            );
    }
}
