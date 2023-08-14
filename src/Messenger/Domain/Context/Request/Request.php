<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request;

use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;

class Request implements RequestInterface
{
    /**
     * @param string $message
     * @param CallbackDataInterface $callbackData
     */
    public function __construct(
        protected string $message,
        protected CallbackDataInterface $callbackData
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
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
