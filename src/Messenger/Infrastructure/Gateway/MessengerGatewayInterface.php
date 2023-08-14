<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gateway;

use Raspberry\Messenger\Infrastructure\Gateway\Exceptions\MessengerException;

interface MessengerGatewayInterface
{
    /**
     * @return void
     * @throws MessengerException
     */
    public function handleRequest(): void;
}
