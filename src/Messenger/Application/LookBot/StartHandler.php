<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\Menu;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;

class StartHandler extends AbstractHandler
{

    /**
     * @param ContextInterface $context
     * @param GuiInterface $gui
     * @param HandlerArgumentsInterface|null $args
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        $gui->sendMessage('Добро пожаловать в Raspberry!');
        $gui->sendReplyKeyboard($this->makeMenu());
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeMenu(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make()
            ->addRow($this->makeMenuButton(Menu::SelectionLook->getText()))
            ->addRow($this->makeMenuButton(Menu::Settings->getText()));
    }

    protected function makeMenuButton(string $text): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->make();
    }
}
