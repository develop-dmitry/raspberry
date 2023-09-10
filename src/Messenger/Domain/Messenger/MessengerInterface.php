<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Messenger;

use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainerInterface;
use Raspberry\Messenger\Domain\Messenger\Exceptions\MessengerException;

interface MessengerInterface
{

    /**
     * @param RunningMode $mode
     * @return void
     * @throws MessengerException
     */
    public function handle(RunningMode $mode): void;

    /**
     * @param HandlerContainerInterface $handlers
     * @return void
     */
    public function setHandlers(HandlerContainerInterface $handlers): void;
}
