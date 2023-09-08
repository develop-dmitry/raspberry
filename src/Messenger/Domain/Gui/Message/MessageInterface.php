<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Message;

use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;

interface MessageInterface
{

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return ReplyKeyboardInterface|null
     */
    public function getReplyKeyboard(): ?ReplyKeyboardInterface;

    /**
     * @return InlineKeyboardInterface|null
     */
    public function getInlineKeyboard(): ?InlineKeyboardInterface;

    /**
     * @return bool
     */
    public function isRemoveKeyboard(): bool;
}
