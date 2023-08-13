<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Context\User;

interface UserInterface
{

    /**
     * @return int
     */
    public function getMessengerId(): int;

    /**
     * @return string
     */
    public function getMessageHandler(): string;

    /**
     * @param string $messageHandler
     * @return void
     */
    public function setMessageHandler(string $messageHandler): void;
}
