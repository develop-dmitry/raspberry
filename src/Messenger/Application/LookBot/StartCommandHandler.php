<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;

class StartCommandHandler extends AbstractHandler
{

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        $gui->sendMessage('Добро пожаловать в Raspberry!');
        $gui->sendReplyKeyboard($this->makeMenu());
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeMenu(): ReplyKeyboardInterface
    {
        $selectionButton = $this->replyButtonFactory
            ->setText('Подобрать образ')
            ->make();

        return $this->replyKeyboardFactory
            ->setResize($this->replyKeyboardOptionFactory->makeResizeOption(true))
            ->make()
            ->addRow($selectionButton);
    }
}
