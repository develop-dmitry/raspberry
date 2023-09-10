<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Messenger;

use Raspberry\Messenger\Domain\Gui\Message\MessageInterface;

interface MessengerGatewayInterface
{

    /**
     * @param MessageInterface $message
     * @return void
     */
    public function sendMessage(MessageInterface $message): void;

    /**
     * @param MessageInterface $message
     * @return void
     */
    public function editMessage(MessageInterface $message): void;
}
