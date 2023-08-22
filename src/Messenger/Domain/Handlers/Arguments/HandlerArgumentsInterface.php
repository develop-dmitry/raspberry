<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers\Arguments;

interface HandlerArgumentsInterface
{

    public function getMessage(): string;
}
