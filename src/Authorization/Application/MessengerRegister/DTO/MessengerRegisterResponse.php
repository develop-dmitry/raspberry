<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerRegister\DTO;

class MessengerRegisterResponse
{

    /**
     * @param int $userId
     * @param string $apiToken
     */
    public function __construct(
        protected int $userId,
        protected string $apiToken
    ) {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->apiToken;
    }
}
