<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Context\User;

class User implements UserInterface
{

    public function __construct(
        protected int $messengerId,
        protected string $messageHandler
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getMessengerId(): int
    {
        return $this->messengerId;
    }

    /**
     * @inheritDoc
     */
    public function getMessageHandler(): string
    {
        return $this->messageHandler;
    }

    /**
     * @inheritDoc
     */
    public function setMessageHandler(string $messageHandler): void
    {
        $this->messageHandler = $messageHandler;
    }
}
