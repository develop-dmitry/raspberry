<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\SettingsHandlers;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\SettingsMenu;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;

class SettingsHandler extends AbstractHandler
{

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        $gui->sendMessage('Настройки');
        $gui->sendReplyKeyboard($this->makeSettingsKeyboard());
    }

    protected function makeSettingsKeyboard(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make()
            ->addRow($this->makeSettingsButton(SettingsMenu::Styles->getText()))
            ->addRow($this->makeSettingsButton(SettingsMenu::Back->getText()));
    }

    protected function makeSettingsButton(string $text): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->make();
    }
}
