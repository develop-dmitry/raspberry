<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuthorization\TelegramMessengerAuthorizationUseCase;
use Raspberry\Authorization\Application\MessengerRegister\TelegramMessengerRegisterUseCase;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Application\LookBot\Enums\Menu;
use Raspberry\Messenger\Application\LookBot\Enums\SettingsMenu;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Application\LookBot\EventHandlers\EventChooseHandler;
use Raspberry\Messenger\Application\LookBot\EventHandlers\EventListHandler;
use Raspberry\Messenger\Application\LookBot\SelectionLookHandler;
use Raspberry\Messenger\Application\LookBot\SettingsHandlers\SettingsHandler;
use Raspberry\Messenger\Application\LookBot\SettingsHandlers\StylesHandler;
use Raspberry\Messenger\Application\LookBot\StartHandler;
use Raspberry\Messenger\Application\LookBot\TemperatureHandlers\InputTemperatureHandler;
use Raspberry\Messenger\Application\LookBot\TemperatureHandlers\SaveTemperatureHandler;
use Raspberry\Messenger\Application\LookBot\WardrobeHandlers\WardrobeHandler;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Infrastructure\Gateway\Exceptions\MessengerException;
use Raspberry\Messenger\Infrastructure\Gateway\TelegramMessengerGateway;

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

        $telegram = app(TelegramMessengerGateway::class, ['handlers' => $this->getHandlers()]);

        try {
            $telegram->handleRequest();
        } catch (MessengerException $exception) {
            $this->logger->emergency(
                'Error while performing telegram request',
                ['exception' => $exception->getMessage()]
            );
        }
    }

    protected function getHandlers(): HandlerContainerInterface
    {
        return (new HandlerContainer())
            ->addHandler(
                'start',
                HandlerType::Command,
                app(StartHandler::class)
            )
            ->addHandler(
                Menu::SelectionLook->getText(),
                HandlerType::Text,
                app(InputTemperatureHandler::class)
            )
            ->addHandler(
                TextAction::SaveTemperature->value,
                HandlerType::Message,
                $this->makeSaveTemperatureHandler()
            )
            ->addHandler(
                Action::EventList->value,
                HandlerType::CallbackQuery,
                $this->makeEventListHandler()
            )
            ->addHandler(
                Action::EventChoose->value,
                HandlerType::CallbackQuery,
                $this->makeEventChooseHandler()
            )
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
            )
            ->addHandler(
                Menu::Wardrobe->getText(),
                HandlerType::Text,
                $this->makeWardrobeHandler()
            );
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
