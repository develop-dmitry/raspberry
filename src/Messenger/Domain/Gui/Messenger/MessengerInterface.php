<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Messenger;

use Raspberry\Messenger\Domain\Gui\Messenger\Exceptions\MessengerException;

interface MessengerInterface
{

    /**
     * @return void
     * @throws MessengerException
     */
    public function handle(): void;
}
