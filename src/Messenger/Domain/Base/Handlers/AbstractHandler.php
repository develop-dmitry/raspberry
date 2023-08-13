<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Handlers;

use Raspberry\Messenger\Domain\Base\Context\ContextInterface;
use Raspberry\Messenger\Domain\Base\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Base\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Buttons\ReplyButton\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton\Factory\InlineButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton\Factory\ReplyButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyKeyboard\Factory\ReplyKeyboardOptionFactoryInterface;

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
