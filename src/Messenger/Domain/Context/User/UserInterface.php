<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\User;

use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Token\TokenInterface;

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

    /**
     * @return GeolocationInterface|null
     */
    public function getGeolocation(): ?GeolocationInterface;

    /**
     * @param GeolocationInterface $geolocation
     * @return void
     */
    public function setGeolocation(GeolocationInterface $geolocation): void;

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return TokenInterface
     */
    public function getApiToken(): TokenInterface;

    /**
     * @param IdInterface $id
     * @param TokenInterface $apiToken
     * @return void
     */
    public function authorize(IdInterface $id, TokenInterface $apiToken): void;
}
