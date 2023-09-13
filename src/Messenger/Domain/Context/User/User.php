<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\User;

use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Token\TokenInterface;

class User implements UserInterface
{

    protected IdInterface $id;

    protected TokenInterface $apiToken;

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

    /**
     * @inheritDoc
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getApiToken(): TokenInterface
    {
        return $this->apiToken;
    }

    /**
     * @inheritDoc
     */
    public function authorize(IdInterface $id, TokenInterface $apiToken): void
    {
        $this->id = $id;
        $this->apiToken = $apiToken;
    }
}
