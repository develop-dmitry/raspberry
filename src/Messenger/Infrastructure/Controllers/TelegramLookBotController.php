<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuthorization\TelegramMessengerAuthorizationUseCase;
use Raspberry\Authorization\Application\MessengerRegister\TelegramMessengerRegisterUseCase;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Application\LookBot\Enums\Menu;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Application\LookBot\EventHandlers\EventChooseHandler;
use Raspberry\Messenger\Application\LookBot\EventHandlers\EventListHandler;
use Raspberry\Messenger\Application\LookBot\SelectionLookHandler;
use Raspberry\Messenger\Application\LookBot\Settings\SettingsHandler;
use Raspberry\Messenger\Application\LookBot\Settings\SettingsMenu;
use Raspberry\Messenger\Application\LookBot\Settings\StylesHandler;
use Raspberry\Messenger\Application\LookBot\StartHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\InputTemperatureHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\SaveTemperatureHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\TemperatureHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\TemperatureMenu;
use Raspberry\Messenger\Application\LookBot\Temperature\WeatherGatewayHandler;
use Raspberry\Messenger\Application\LookBot\Wardrobe\WardrobeHandler;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Infrastructure\Gui\Telegram\TelegramMessenger;

class TelegramLookBotController extends Controller
{
    public function __construct(
        protected LoggerInterface $logger,
        protected TelegramMessengerAuthorizationUseCase $messengerAuthorization,
        protected TelegramMessengerRegisterUseCase $messengerRegister
    ) {
    }

    public function __invoke(Request $request): void
    {
        $this->logger->debug('Request from telegram', $request->toArray());

        $telegram = app(TelegramMessenger::class, ['handlers' => $this->getHandlers()]);

        try {
            $telegram->handle();
        } catch (Exception $exception) {
            $this->logger->emergency(
                'Error while performing telegram request',
                ['exception' => $exception->getMessage()]
            );
        }
    }

    protected function getHandlers(): HandlerContainerInterface
    {
        $container = new HandlerContainer();

        $this->addCommonHandlers($container);
        $this->addTemperatureHandlers($container);
        $this->addSettingsHandlers($container);
        $this->addWardrobeHandlers($container);
        $this->addEventHandlers($container);

        return $container;
    }

    public function addCommonHandlers(HandlerContainerInterface $container): void
    {
        $container
            ->addHandler(
                'start',
                HandlerType::Command,
                app(StartHandler::class)
            );
    }

    public function addTemperatureHandlers(HandlerContainerInterface $container): void
    {
        $container
            ->addHandler(
                Menu::SelectionLook->getText(),
                HandlerType::Text,
                $this->makeTemperatureHandler()
            )
            ->addHandler(
                TextAction::SaveTemperature->value,
                HandlerType::Message,
                $this->makeSaveTemperatureHandler()
            )
            ->addHandler(
                TemperatureMenu::Input->getText(),
                HandlerType::Text,
                app(InputTemperatureHandler::class)
            )
            ->addHandler(
                TextAction::GatewayTemperature->value,
                HandlerType::Message,
                $this->makeWeatherGatewayHandler()
            )
            ->addHandler(
                TemperatureMenu::Accept->getText(),
                HandlerType::Text,
                $this->makeEventListHandler()
            );
    }

    public function addSettingsHandlers(HandlerContainerInterface $container): void
    {
        $container
            ->addHandler(
                Menu::Settings->getText(),
                HandlerType::Text,
                app(SettingsHandler::class)
            )
            ->addHandler(
                SettingsMenu::Styles->getText(),
                HandlerType::Text,
                $this->makeStylesHandler()
            )
            ->addHandler(
                Action::StylesUser->value,
                HandlerType::CallbackQuery,
                $this->makeStylesHandler()
            )
            ->addHandler(
                Action::StylesChoose->value,
                HandlerType::CallbackQuery,
                $this->makeStylesHandler()
            )
            ->addHandler(
                SettingsMenu::Back->getText(),
                HandlerType::Text,
                app(StartHandler::class)
            );
    }

    public function addWardrobeHandlers(HandlerContainerInterface $container): void
    {
        $container
            ->addHandler(
                Menu::Wardrobe->getText(),
                HandlerType::Text,
                $this->makeWardrobeHandler()
            );
    }

    public function addEventHandlers(HandlerContainerInterface $container): void
    {
        $container
            ->addHandler(
                Action::EventList->value,
                HandlerType::CallbackQuery,
                $this->makeEventListHandler()
            )
            ->addHandler(
                Action::EventChoose->value,
                HandlerType::CallbackQuery,
                $this->makeEventChooseHandler()
            );
    }

    protected function makeTemperatureHandler(): HandlerInterface
    {
        return app(TemperatureHandler::class, [
            'weatherGatewayHandler' => $this->makeWeatherGatewayHandler()
        ]);
    }

    protected function makeWeatherGatewayHandler(): HandlerInterface
    {
        return app(WeatherGatewayHandler::class, [
            'messengerAuthorization' => $this->messengerAuthorization,
            'messengerRegister' => $this->messengerRegister
        ]);
    }

    protected function makeWardrobeHandler(): HandlerInterface
    {
        return app(WardrobeHandler::class, [
            'messengerAuthorization' => $this->messengerAuthorization,
            'messengerRegister' => $this->messengerRegister
        ]);
    }

    protected function makeStylesHandler(): HandlerInterface
    {
        return app(StylesHandler::class, [
            'messengerAuthorization' => $this->messengerAuthorization,
            'messengerRegister' => $this->messengerRegister
        ]);
    }

    protected function makeSaveTemperatureHandler(): HandlerInterface
    {
        return app(SaveTemperatureHandler::class, [
            'messengerAuthorization' => $this->messengerAuthorization,
            'messengerRegister' => $this->messengerRegister,
            'next' => $this->makeEventListHandler()
        ]);
    }

    protected function makeEventChooseHandler(): HandlerInterface
    {
        return app(EventChooseHandler::class, [
            'back' => $this->makeEventListHandler(),
            'next' => $this->makeSelectionLookHandler(),
            'messengerAuthorization' => $this->messengerAuthorization,
            'messengerRegister' => $this->messengerRegister
        ]);
    }

    protected function makeEventListHandler(): HandlerInterface
    {
        return app(EventListHandler::class);
    }

    protected function makeSelectionLookHandler(): HandlerInterface
    {
        return app(SelectionLookHandler::class, [
            'messengerAuthorization' => $this->messengerAuthorization,
            'messengerRegister' => $this->messengerRegister
        ]);
    }
}
