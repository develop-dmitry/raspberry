<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory\GuiFactory;

use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactory\ReplyKeyboardFactoryInterface;

interface GuiFactoryInterface
{
    /**
     * @return InlineButtonFactoryInterface
     */
    public function makeInlineButtonFactory(): InlineButtonFactoryInterface;

    /**
     * @return InlineKeyboardFactoryInterface
     */
    public function makeInlineKeyboardFactory(): InlineKeyboardFactoryInterface;

    /**
     * @return ReplyButtonFactoryInterface
     */
    public function makeReplyButtonFactory(): ReplyButtonFactoryInterface;

    /**
     * @return ReplyKeyboardFactoryInterface
     */
    public function makeReplyKeyboardFactory(): ReplyKeyboardFactoryInterface;
}
