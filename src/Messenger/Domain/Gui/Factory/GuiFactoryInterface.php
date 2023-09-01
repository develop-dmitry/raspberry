<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory;

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
