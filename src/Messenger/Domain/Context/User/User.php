<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\User;

use Raspberry\Common\Values\Geolocation\GeolocationInterface;

class User implements UserInterface
{

    /**
     * @param int $messengerId
     * @param string $messageHandler
     * @param GeolocationInterface|null $geolocation
     */
    public function __construct(
        protected int $messengerId,
        protected string $messageHandler,
        protected ?GeolocationInterface $geolocation
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

    /**
     * @inheritDoc
     */
    public function getGeolocation(): ?GeolocationInterface
    {
        return $this->geolocation;
    }

    /**
     * @inheritDoc
     */
    public function setGeolocation(GeolocationInterface $geolocation): void
    {
        $this->geolocation = $geolocation;
    }
}
