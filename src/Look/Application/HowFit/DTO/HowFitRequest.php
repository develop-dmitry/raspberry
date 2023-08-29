<?php

namespace Raspberry\Look\Application\HowFit\DTO;

class HowFitRequest
{

    /**
     * @param int $userId
     * @param int $lookId
     */
    public function __construct(
        protected int $userId,
        protected int $lookId
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
     * @return int
     */
    public function getLookId(): int
    {
        return $this->lookId;
    }
}
