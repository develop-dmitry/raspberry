<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected ?UserInterface $contextUser;

    protected RequestInterface $contextRequest;

    protected GuiInterface $gui;

    protected ?HandlerArgumentsInterface $args;

    protected InlineButtonFactoryInterface $inlineButtonFactory;

    protected ReplyButtonFactoryInterface $replyButtonFactory;

    protected InlineKeyboardFactoryInterface $inlineKeyboardFactory;

    protected ReplyKeyboardFactoryInterface $replyKeyboardFactory;

    /**
     * @param ContextInterface $context
     * @param GuiInterface $gui
     * @param HandlerArgumentsInterface|null $args
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        $this->contextRequest = $context->getRequest();
        $this->contextUser = $context->getUser();
        $this->gui = $gui;
        $this->args = $args;

       $this->initFactories();
    }

    private function initFactories(): void
    {
        $guiFactory = $this->gui->getGuiFactory();

        $this->inlineButtonFactory = $guiFactory->makeInlineButtonFactory();
        $this->replyButtonFactory = $guiFactory->makeReplyButtonFactory();
        $this->inlineKeyboardFactory = $guiFactory->makeInlineKeyboardFactory();
        $this->replyKeyboardFactory = $guiFactory->makeReplyKeyboardFactory();
    }
}
