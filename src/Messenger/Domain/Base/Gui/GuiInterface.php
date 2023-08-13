<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui;

use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;

interface GuiInterface
{
    /**
     * @return GuiInterface
     */
    public function editMessage(): self;

    /**
     * @param string $message
     * @return GuiInterface
     */
    public function sendMessage(string $message): self;

    /**
     * @param ReplyKeyboardInterface $keyboard
     * @return self
     */
    public function sendReplyKeyboard(ReplyKeyboardInterface $keyboard): self;

    /**
     * @param InlineKeyboardInterface $keyboard
     * @return self
     */
    public function sendInlineKeyboard(InlineKeyboardInterface $keyboard): self;
}
