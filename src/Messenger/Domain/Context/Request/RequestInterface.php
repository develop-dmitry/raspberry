<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request;

use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;

interface RequestInterface
{
    /**
     * @return CallbackDataInterface
     */
    public function getCallbackData(): CallbackDataInterface;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return HandlerTypeEnum
     */
    public function getRequestType(): HandlerTypeEnum;
}
