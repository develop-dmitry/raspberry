<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers\Arguments;

class HandlerArguments implements HandlerArgumentsInterface
{

    public function __construct(
        protected string $message
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
