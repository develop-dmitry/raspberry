<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Messenger\Telegram;

use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\Message\MessageInterface;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

class TelegramAdapter
{

    public function __construct(
        protected MessageInterface $message
    ) {
    }

    /**
     * @return ReplyKeyboardMarkup|InlineKeyboardMarkup|ReplyKeyboardRemove|null
     */
    public function makeTelegramKeyboard(): ReplyKeyboardMarkup|InlineKeyboardMarkup|ReplyKeyboardRemove|null
    {
        if ($this->message->getReplyKeyboard()) {
            return $this->makeReplyKeyboardMarkup();
        }

        if ($this->message->getInlineKeyboard()) {
            return $this->makeInlineKeyboardMarkup();
        }

        if ($this->message->isRemoveKeyboard()) {
            return new ReplyKeyboardRemove(true);
        }

        return null;
    }

    /**
     * @return string
     */
    public function makeText(): string
    {
        return $this->message->getText();
    }

    /**
     * @return ReplyKeyboardMarkup
     */
    protected function makeReplyKeyboardMarkup(): ReplyKeyboardMarkup
    {
        $keyboard = new ReplyKeyboardMarkup($this->message->getReplyKeyboard()->isResize()->getValue());

        foreach ($this->message->getReplyKeyboard()->getRows() as $row) {
            $keyboard->addRow(...array_map([$this, 'makeReplyButton'], $row));
        }

        return $keyboard;
    }

    /**
     * @param ReplyButtonInterface $button
     * @return KeyboardButton
     */
    protected function makeReplyButton(ReplyButtonInterface $button): KeyboardButton
    {
        return new KeyboardButton(
            $button->getText(),
            request_location: $button->getSendLocation()->getValue(),
            web_app: ($button->getWebApp()->getValue()) ? new WebAppInfo($button->getWebApp()->getValue()) : null
        );
    }

    /**
     * @return InlineKeyboardMarkup
     */
    protected function makeInlineKeyboardMarkup(): InlineKeyboardMarkup
    {
        $keyboard = new InlineKeyboardMarkup();

        foreach ($this->message->getInlineKeyboard()->getRows() as $row) {
            $keyboard->addRow(...array_map([$this, 'makeInlineKeyboardButton'], $row));
        }

        return $keyboard;
    }

    /**
     * @param InlineButtonInterface $button
     * @return InlineKeyboardButton
     */
    protected function makeInlineKeyboardButton(InlineButtonInterface $button): InlineKeyboardButton
    {
        return new InlineKeyboardButton(
            $button->getText(),
            url: $button->getUrl()->getValue(),
            callback_data: $button->getCallbackData()->getValue(),
            web_app: ($button->getWebApp()->getValue()) ? new WebAppInfo($button->getWebApp()->getValue()) : null
        );
    }
}
