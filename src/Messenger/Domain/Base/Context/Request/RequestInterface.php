<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Context\Request;

use Raspberry\Messenger\Domain\Base\Context\Request\CallbackData\CallbackDataInterface;

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
}
