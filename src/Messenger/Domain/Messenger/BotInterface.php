<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Messenger;

use Raspberry\Messenger\Domain\Messenger\Exceptions\MessengerException;

interface BotInterface
{

    /**
     * @param RunningMode $runningMode
     * @return void
     * @throws MessengerException
     */
    public function handle(RunningMode $runningMode): void;
}
