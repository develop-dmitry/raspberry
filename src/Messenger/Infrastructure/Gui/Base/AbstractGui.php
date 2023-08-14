<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Base;

use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\GuiFactory;

class AbstractGui implements GuiInterface
{
    protected bool $isEditMessage = false;

    protected string $message = '';

    protected ?ReplyKeyboardInterface $replyKeyboard = null;

    protected ?InlineKeyboardInterface $inlineKeyboard = null;

    protected GuiFactoryInterface $guiFactory;

    public function __construct()
    {
        $this->guiFactory = new GuiFactory();
    }

    /**
     * @inheritDoc
     */
    public function editMessage(): GuiInterface
    {
        $this->isEditMessage = true;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(string $message): GuiInterface
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function sendReplyKeyboard(ReplyKeyboardInterface $keyboard): GuiInterface
    {
        $this->replyKeyboard = $keyboard;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function sendInlineKeyboard(InlineKeyboardInterface $keyboard): GuiInterface
    {
        $this->inlineKeyboard = $keyboard;
        return $this;
    }

    public function getGuiFactory(): GuiFactoryInterface
    {
        return $this->guiFactory;
    }
}
