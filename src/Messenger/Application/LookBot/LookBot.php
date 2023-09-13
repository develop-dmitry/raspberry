<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Raspberry\Messenger\Application\LookBot\Common\StartHandler;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Application\LookBot\Enums\Menu;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Application\LookBot\Event\EventChooseHandler;
use Raspberry\Messenger\Application\LookBot\Event\EventListHandler;
use Raspberry\Messenger\Application\LookBot\Settings\SettingsHandler;
use Raspberry\Messenger\Application\LookBot\Settings\SettingsMenu;
use Raspberry\Messenger\Application\LookBot\Settings\UserStylesHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\InputTemperatureHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\SaveTemperatureHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\TemperatureHandler;
use Raspberry\Messenger\Application\LookBot\Temperature\TemperatureMenu;
use Raspberry\Messenger\Application\LookBot\Temperature\WeatherGatewayHandler;
use Raspberry\Messenger\Application\LookBot\Wardrobe\WardrobeHandler;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\Exceptions\MessengerException;
use Raspberry\Messenger\Domain\Messenger\MessengerInterface;
use Raspberry\Messenger\Domain\Messenger\RunningMode;

class LookBot
{

    public function __construct(
        protected MessengerInterface $messenger,
        TemperatureHandler           $temperatureHandler,
        SaveTemperatureHandler       $saveTemperatureHandler,
        InputTemperatureHandler      $inputTemperatureHandler,
        WeatherGatewayHandler        $temperatureGatewayHandler,
        EventListHandler             $eventListHandler,
        EventChooseHandler           $eventChooseHandler,
        SettingsHandler              $settingsHandler,
        UserStylesHandler            $stylesUserHandler,
        StartHandler                 $startHandler,
        WardrobeHandler              $wardrobeHandler,
    ) {
        $handlers = (new HandlerContainer())
            ->addHandler('start', HandlerType::Command, $startHandler)
            ->addHandler(Menu::SelectionLook->getText(), HandlerType::Text, $temperatureHandler)
            ->addHandler(TextAction::SaveTemperature->value, HandlerType::Message, $saveTemperatureHandler)
            ->addHandler(TemperatureMenu::Input->getText(), HandlerType::Text, $inputTemperatureHandler)
            ->addHandler(TextAction::GatewayTemperature->value, HandlerType::Message, $temperatureGatewayHandler)
            ->addHandler(TemperatureMenu::Accept->getText(), HandlerType::Text, $eventListHandler)
            ->addHandler(Menu::Settings->getText(), HandlerType::Text, $settingsHandler)
            ->addHandler(SettingsMenu::Styles->getText(), HandlerType::Text, $stylesUserHandler)
            ->addHandler(Action::StylesUser->value, HandlerType::CallbackQuery, $stylesUserHandler)
            ->addHandler(Action::StylesChoose->value, HandlerType::CallbackQuery, $stylesUserHandler)
            ->addHandler(SettingsMenu::Back->getText(), HandlerType::Text, $startHandler)
            ->addHandler(Menu::Wardrobe->getText(), HandlerType::Text, $wardrobeHandler)
            ->addHandler(Action::EventList->value, HandlerType::CallbackQuery, $eventListHandler)
            ->addHandler(Action::EventChoose->value, HandlerType::CallbackQuery, $eventChooseHandler);

        $this->messenger->setHandlers($handlers);
    }

    /**
     * @param RunningMode $runningMode
     * @return void
     * @throws MessengerException
     */
    public function handle(RunningMode $runningMode): void
    {
        $this->messenger->handle($runningMode);
    }
}
