<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Messenger;

use Raspberry\Messenger\Domain\Base\Messenger\Exceptions\MessengerException;

interface MessengerGatewayInterface
{
    /**
     * @return void
     * @throws MessengerException
     */
    public function handleRequest(): void;
}
