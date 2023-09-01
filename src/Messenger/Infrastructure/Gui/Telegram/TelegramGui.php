<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Telegram;

use Psr\Log\LoggerInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Infrastructure\Gui\Base\AbstractGui;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

class TelegramGui extends AbstractGui
{

    public function __construct(
        protected LoggerInterface $logger
    ) {
        parent::__construct();
    }

    /**
     * @return ReplyKeyboardMarkup|InlineKeyboardMarkup|null
     */
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

    /**
     * @return bool
     */
    protected function hasReplyKeyboard(): bool
    {
        return !is_null($this->replyKeyboard);
    }

    /**
     * @return bool
     */
    protected function hasInlineKeyboard(): bool
    {
        return !is_null($this->inlineKeyboard);
    }

    /**
     * @return ReplyKeyboardMarkup
     */
    protected function makeReplyKeyboardMarkup(): ReplyKeyboardMarkup
    {
        $keyboard = new ReplyKeyboardMarkup($this->replyKeyboard->isResize()->getValue());

        foreach ($this->replyKeyboard->getRows() as $row) {
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

        foreach ($this->inlineKeyboard->getRows() as $row) {
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
