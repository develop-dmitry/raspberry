<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\Factory\InlineButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyButton\Factory\ReplyButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\Factory\ReplyKeyboardOptionFactoryInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected ?UserInterface $contextUser;

    protected RequestInterface $contextRequest;

    public function __construct(
        protected InlineButtonFactoryInterface $inlineButtonFactory,
        protected ReplyButtonFactoryInterface $replyButtonFactory,
        protected InlineKeyboardFactoryInterface $inlineKeyboardFactory,
        protected ReplyKeyboardFactoryInterface $replyKeyboardFactory,
        protected InlineButtonOptionFactoryInterface $inlineButtonOptionFactory,
        protected ReplyKeyboardOptionFactoryInterface $replyKeyboardOptionFactory,
        protected ReplyButtonOptionFactoryInterface $replyButtonOptionFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        $this->contextRequest = $context->getRequest();
        $this->contextUser = $context->getUser();
    }
}
