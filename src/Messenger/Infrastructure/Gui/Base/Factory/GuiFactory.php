<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Base\Factory;

use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactoryInterface;

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
