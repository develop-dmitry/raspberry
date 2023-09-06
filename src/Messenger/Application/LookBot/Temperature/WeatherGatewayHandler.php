<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Exception;
use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\GeolocationInterface;
use Raspberry\Common\Values\Temperature\Temperature;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Weather\Application\ActualWeather\ActualWeatherInterface;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherRequest;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;

class WeatherGatewayHandler extends AbstractHandler
{
    use AuthorizeTrait;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        protected ActualWeatherInterface $actualWeather
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        $this->identifyUser($this->contextUser?->getMessengerId());

        if (!$this->contextRequest->getGeolocation() && !$this->contextUser->getGeolocation()) {
            $gui->sendMessage('Не удалось получить местоположение');
            return;
        }

        if ($this->contextRequest->getGeolocation()) {
            $this->contextUser->setGeolocation($this->contextRequest->getGeolocation());
        }

        $geolocation = $this->contextUser->getGeolocation();

        try {
            $temperature = $this->getTemperature($geolocation);
            (new SelectionLookRepository($this->userId))->setTemperature($temperature);

            $gui->sendMessage("Ваше местоположение {$geolocation->getDecimal()}\nТемпература {$temperature}")
                ->sendInlineKeyboard($this->makeKeyboard());
        } catch (Exception) {
            $gui->sendMessage('Не удалось получить текущую температуру, введите температуру вручную');
        }
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

    protected function makeKeyboard(): InlineKeyboardInterface
    {
        return $this->inlineKeyboardFactory
            ->make()
            ->addRow(
                $this->inlineButtonFactory
                    ->setText('Подтвердить')
                    ->setCallbackData(new CallbackDataOption(Action::EventList->value, []))
                    ->make()
            );
    }
}
