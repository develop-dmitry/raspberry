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
     * @return InlineButtonOptionFactoryInterface
     */
    public function makeInlineButtonOptionFactory(): InlineButtonOptionFactoryInterface;

    /**
     * @return InlineKeyboardFactoryInterface
     */
    public function makeInlineKeyboardFactory(): InlineKeyboardFactoryInterface;

    /**
     * @return ReplyButtonFactoryInterface
     */
    public function makeReplyButtonFactory(): ReplyButtonFactoryInterface;

    /**
     * @return ReplyButtonOptionFactoryInterface
     */
    public function makeReplyButtonOptionFactory(): ReplyButtonOptionFactoryInterface;

    /**
     * @return ReplyKeyboardFactoryInterface
     */
    public function makeReplyKeyboardFactory(): ReplyKeyboardFactoryInterface;

    /**
     * @return ReplyKeyboardOptionFactoryInterface
     */
    public function makeReplyKeyboardOptionFactory(): ReplyKeyboardOptionFactoryInterface;
}
