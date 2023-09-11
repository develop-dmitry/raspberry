<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\ReplyButton\SendLocationOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;
use Raspberry\Weather\Application\ActualWeather\ActualWeatherInterface;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherRequest;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class WeatherGatewayHandler extends AbstractHandler
{

    /**
     * @param ActualWeatherInterface $actualWeather
     * @param LoggerInterface $logger
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected ActualWeatherInterface $actualWeather,
        protected LoggerInterface $logger,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @inheritDoc
     */
    public function isNeedAuthorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        if ($this->contextRequest->getGeolocation()) {
            $this->contextUser->setGeolocation($this->contextRequest->getGeolocation());
        }

        if ($geolocation = $this->contextUser->getGeolocation()) {
            try {
                $temperature = new Temperature($this->getTemperature($geolocation));
                (new SelectionLookRepository($this->contextUser->getId()->getValue()))
                    ->setTemperature($temperature->getValue());

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
     * @throws UnknownProperties
     */
    protected function getTemperature(GeolocationInterface $geolocation): int
    {
        $request = new ActualWeatherRequest(
            lat: $geolocation->getLat(),
            lon: $geolocation->getLon()
        );
        $response = $this->actualWeather->execute($request);

        return $response->temperature;
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
