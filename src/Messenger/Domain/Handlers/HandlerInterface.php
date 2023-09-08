<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Gui\Messenger\MessengerGatewayInterface;

interface HandlerInterface
{
    /**
     * @param ContextInterface $context
     * @param MessengerGatewayInterface $messenger
     * @return void
     * @throws FailedAuthorizeException
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void;
}
