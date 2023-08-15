<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuthorization\DTO;

class MessengerAuthorizationRequest
{

    /**
     * @param int $messengerId
     */
    public function __construct(
        protected int $messengerId
    ) {
    }

    /**
     * @return int
     */
    public function getMessengerId(): int
    {
        return $this->messengerId;
    }
}
