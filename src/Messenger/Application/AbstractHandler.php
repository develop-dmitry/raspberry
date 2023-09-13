<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected ?UserInterface $contextUser;

    protected RequestInterface $contextRequest;

    protected InlineButtonFactoryInterface $inlineButtonFactory;

    protected ReplyButtonFactoryInterface $replyButtonFactory;

    protected InlineKeyboardFactoryInterface $inlineKeyboardFactory;

    protected ReplyKeyboardFactoryInterface $replyKeyboardFactory;

    /**
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        private readonly GuiFactoryInterface $guiFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        $this->contextUser = $context->getUser();
        $this->contextRequest = $context->getRequest();

        $this->initFactories();
    }

    /**
     * @inheritDoc
     */
    public function isNeedAuthorize(): bool
    {
        return false;
    }

    /**
     * @return void
     */
    private function initFactories(): void
    {
        $this->inlineButtonFactory = $this->guiFactory->makeInlineButtonFactory();
        $this->replyButtonFactory = $this->guiFactory->makeReplyButtonFactory();
        $this->inlineKeyboardFactory = $this->guiFactory->makeInlineKeyboardFactory();
        $this->replyKeyboardFactory = $this->guiFactory->makeReplyKeyboardFactory();
    }

    /**
     * @return CallbackDataInterface
     */
    protected function getCallbackData(): CallbackDataInterface
    {
        return $this->contextRequest->getCallbackData();
    }

    /**
     * @return HandlerType
     */
    protected function getRequestType(): HandlerType
    {
        return $this->contextRequest->getRequestType();
    }
}
