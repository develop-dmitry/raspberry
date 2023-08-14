<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Domain\Gui;

use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Infrastructure\Gui\Telegram\TelegramGui;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use Tests\TestCase;

class TelegramGuiTest extends TestCase
{
    protected ReplyButtonFactoryInterface $replyButtonFactory;

    protected ReplyKeyboardFactoryInterface $replyKeyboardFactory;

    protected InlineButtonFactoryInterface $inlineButtonFactory;

    protected InlineKeyboardFactoryInterface $inlineKeyboardFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->replyKeyboardFactory = $this->app->make(ReplyKeyboardFactoryInterface::class);
        $this->replyButtonFactory = $this->app->make(ReplyButtonFactoryInterface::class);
        $this->inlineKeyboardFactory = $this->app->make(InlineKeyboardFactoryInterface::class);
        $this->inlineButtonFactory = $this->app->make(InlineButtonFactoryInterface::class);
    }

    public function testMakeTelegramReplyKeyboard(): void
    {
        $replyKeyboard = $this->makeReplyKeyboard();
        $gui = $this->app->make(TelegramGui::class);
        $gui->sendReplyKeyboard($replyKeyboard);

        $telegramReplyKeyboard = $gui->makeTelegramKeyboard();

        $this->assertInstanceOf(ReplyKeyboardMarkup::class, $telegramReplyKeyboard);
    }

    public function testMakeTelegramInlineKeyboard(): void
    {
        $inlineKeyboard = $this->makeInlineKeyboard();
        $gui = $this->app->make(TelegramGui::class);
        $gui->sendInlineKeyboard($inlineKeyboard);

        $telegramInlineKeyboard = $gui->makeTelegramKeyboard();

        $this->assertInstanceOf(InlineKeyboardMarkup::class, $telegramInlineKeyboard);
    }

    public function testMakeEmptyTelegramKeyboard(): void
    {
        $gui = $this->app->make(TelegramGui::class);

        $emptyTelegramKeyboard = $gui->makeTelegramKeyboard();

        $this->assertNull($emptyTelegramKeyboard);
    }

    protected function makeInlineKeyboard(): InlineKeyboardInterface
    {
        return $this->inlineKeyboardFactory
            ->make()
            ->addRow($this->makeInlineButton())
            ->addRow($this->makeInlineButton())
            ->addRow($this->makeInlineButton());
    }

    protected function makeInlineButton(): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText('Inline button test text')
            ->make();
    }

    protected function makeReplyKeyboard(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory->make()
            ->addRow($this->makeReplyButton())
            ->addRow($this->makeReplyButton())
            ->addRow($this->makeReplyButton());
    }

    protected function makeReplyButton(): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText('Reply button test text')
            ->make();
    }
}
