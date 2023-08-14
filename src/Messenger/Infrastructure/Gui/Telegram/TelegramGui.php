<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Telegram;

use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Infrastructure\Gui\Base\AbstractGui;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class TelegramGui extends AbstractGui
{

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isEditMessage(): bool
    {
        return $this->isEditMessage;
    }

    public function makeTelegramKeyboard(): ReplyKeyboardMarkup|InlineKeyboardMarkup|null
    {
        if ($this->hasReplyKeyboard()) {
            return $this->makeReplyKeyboardMarkup();
        }

        if ($this->hasInlineKeyboard()) {
            return $this->makeInlineKeyboardMarkup();
        }

        return null;
    }

    protected function hasReplyKeyboard(): bool
    {
        return !is_null($this->replyKeyboard);
    }

    protected function hasInlineKeyboard(): bool
    {
        return !is_null($this->inlineKeyboard);
    }

    protected function makeReplyKeyboardMarkup(): ReplyKeyboardMarkup
    {
        $keyboard = new ReplyKeyboardMarkup($this->replyKeyboard->isResize()->getValue());

        foreach ($this->replyKeyboard->getRows() as $row) {
            $keyboard->addRow(...array_map([$this, 'makeReplyButton'], $row));
        }

        return $keyboard;
    }

    protected function makeReplyButton(ReplyButtonInterface $button): KeyboardButton
    {
        return new KeyboardButton(
            $button->getText(),
            request_location: $button->getSendLocation()->getValue()
        );
    }

    protected function makeInlineKeyboardMarkup(): InlineKeyboardMarkup
    {
        $keyboard = new InlineKeyboardMarkup();

        foreach ($this->inlineKeyboard->getRows() as $row) {
            $keyboard->addRow(...array_map([$this, 'makeInlineKeyboardButton'], $row));
        }

        return $keyboard;
    }

    protected function makeInlineKeyboardButton(InlineButtonInterface $button): InlineKeyboardButton
    {
        return new InlineKeyboardButton(
            $button->getText(),
            callback_data: $button->getCallbackData()->getValue()
        );
    }
}
