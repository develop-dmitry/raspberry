<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory\GuiFactory;

use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactory\InlineButtonFactory;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory\InlineKeyboardFactory;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactory\ReplyButtonFactory;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactory\ReplyKeyboardFactory;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactory\ReplyKeyboardFactoryInterface;

class GuiFactory implements GuiFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function makeInlineButtonFactory(): InlineButtonFactoryInterface
    {
        return new InlineButtonFactory();
    }

    /**
     * @inheritDoc
     */
    public function makeInlineKeyboardFactory(): InlineKeyboardFactoryInterface
    {
        return new InlineKeyboardFactory();
    }

    /**
     * @inheritDoc
     */
    public function makeReplyButtonFactory(): ReplyButtonFactoryInterface
    {
        return new ReplyButtonFactory();
    }

    /**
     * @inheritDoc
     */
    public function makeReplyKeyboardFactory(): ReplyKeyboardFactoryInterface
    {
        return new ReplyKeyboardFactory();
    }
}
