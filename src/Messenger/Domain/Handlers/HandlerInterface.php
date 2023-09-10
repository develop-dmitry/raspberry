<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

interface HandlerInterface
{
    /**
     * @param ContextInterface $context
     * @param MessengerGatewayInterface $messenger
     * @return void
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void;

    /**
     * @return bool
     */
    public function isNeedAuthorize(): bool;
}
