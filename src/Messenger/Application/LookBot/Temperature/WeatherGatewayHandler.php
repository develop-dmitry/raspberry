<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Core\Values\Temperature\TemperatureInterface;
use Raspberry\Look\Domain\Look\Services\Picker\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Infrastructure\Repositories\PickerRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
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
                $temperature = $this->getTemperature($geolocation);
                $this->saveTemperature($temperature);

                $text = "Ваше местоположение {$geolocation->getDecimal()}\nТемпература {$temperature->getCelsius()}";
                $message = Message::withReplyKeyboard($text, $this->makeTemperatureMenu());
            } catch (Exception $exception) {
                $this->logger->debug('Error while execute weather gateway handler', [
                    'exception' => $exception->getMessage()
                ]);

                $this->contextUser->setMessageHandler(TextAction::SaveTemperature->value);
                $message = Message::text('Не удалось получить текущую температуру, введите температуру вручную');
            }
        } else {
            $message = Message::text('Не удалось получить местоположение');
        }

        $messenger->sendMessage($message);
    }

    /**
     * @param GeolocationInterface $geolocation
     * @return TemperatureInterface
     * @throws InvalidValueException
     * @throws UnknownProperties
     * @throws WeatherGatewayException
     */
    protected function getTemperature(GeolocationInterface $geolocation): TemperatureInterface
    {
        $request = new ActualWeatherRequest(
            lat: $geolocation->getLat(),
            lon: $geolocation->getLon()
        );
        $response = $this->actualWeather->execute($request);

        return new Temperature($response->temperature);
    }

    /**
     * @param TemperatureInterface $temperature
     * @return void
     * @throws FailedSavePropertyException
     */
    protected function saveTemperature(TemperatureInterface $temperature): void
    {
        $pickerRepository = new PickerRepository($this->contextUser->getId()->getValue());
        $pickerRepository->setTemperature($temperature->getValue());
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
