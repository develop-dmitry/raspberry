<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request;

use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;

class Request implements RequestInterface
{
    /**
     * @param string $message
     * @param CallbackDataInterface $callbackData
     * @param HandlerTypeEnum $requestType
     */
    public function __construct(
        protected string $message,
        protected CallbackDataInterface $callbackData,
        protected HandlerTypeEnum $requestType
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCallbackData(): CallbackDataInterface
    {
        return $this->callbackData;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getRequestType(): HandlerTypeEnum
    {
        return $this->requestType;
    }
}
