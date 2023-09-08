<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Message;

use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;

class Message implements MessageInterface
{

    /**
     * @param string $text
     * @param ReplyKeyboardInterface|null $replyKeyboard
     * @param InlineKeyboardInterface|null $inlineKeyboard
     * @param bool $isRemoveKeyboard
     */
    protected function __construct(
        protected string $text,
        protected ?ReplyKeyboardInterface $replyKeyboard,
        protected ?InlineKeyboardInterface $inlineKeyboard,
        protected bool $isRemoveKeyboard,
    ) {
    }

    /**
     * @param string $text
     * @return self
     */
    public static function text(string $text): self
    {
        return new self($text, null, null, false);
    }

    /**
     * @param string $text
     * @param ReplyKeyboardInterface $keyboard
     * @return self
     */
    public static function withReplyKeyboard(string $text, ReplyKeyboardInterface $keyboard): self
    {
        return new self($text, $keyboard, null, false);
    }

    /**
     * @param string $text
     * @param InlineKeyboardInterface $keyboard
     * @return self
     */
    public static function withInlineKeyboard(string $text, InlineKeyboardInterface $keyboard): self
    {
        return new self($text, null, $keyboard, false);
    }

    /**
     * @param string $text
     * @return self
     */
    public static function removeKeyboard(string $text): self
    {
        return new self($text, null, null, true);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function getReplyKeyboard(): ?ReplyKeyboardInterface
    {
        return $this->replyKeyboard;
    }

    /**
     * @inheritDoc
     */
    public function getInlineKeyboard(): ?InlineKeyboardInterface
    {
        return $this->inlineKeyboard;
    }

    /**
     * @inheritDoc
     */
    public function isRemoveKeyboard(): bool
    {
        return $this->isRemoveKeyboard;
    }
}
