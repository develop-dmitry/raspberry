<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected ?UserInterface $contextUser;

    protected RequestInterface $contextRequest;

    protected GuiInterface $gui;

    protected InlineButtonFactoryInterface $inlineButtonFactory;

    protected ReplyButtonFactoryInterface $replyButtonFactory;

    protected InlineKeyboardFactoryInterface $inlineKeyboardFactory;

    protected ReplyKeyboardFactoryInterface $replyKeyboardFactory;

    protected InlineButtonOptionFactoryInterface $inlineButtonOptionFactory;

    protected ReplyKeyboardOptionFactoryInterface $replyKeyboardOptionFactory;

    protected ReplyButtonOptionFactoryInterface $replyButtonOptionFactory;

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        $this->contextRequest = $context->getRequest();
        $this->contextUser = $context->getUser();
        $this->gui = $gui;

       $this->initFactories();
    }

    private function initFactories(): void
    {
        $guiFactory = $this->gui->getGuiFactory();

        $this->inlineButtonFactory = $guiFactory->makeInlineButtonFactory();
        $this->replyButtonFactory = $guiFactory->makeReplyButtonFactory();
        $this->inlineKeyboardFactory = $guiFactory->makeInlineKeyboardFactory();
        $this->replyKeyboardFactory = $guiFactory->makeReplyKeyboardFactory();
        $this->inlineButtonOptionFactory = $guiFactory->makeInlineButtonOptionFactory();
        $this->replyKeyboardOptionFactory = $guiFactory->makeReplyKeyboardOptionFactory();
        $this->replyButtonOptionFactory = $guiFactory->makeReplyButtonOptionFactory();
    }
}
