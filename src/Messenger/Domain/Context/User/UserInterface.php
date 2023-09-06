<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\User;

use Raspberry\Common\Values\Geolocation\GeolocationInterface;

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
}
