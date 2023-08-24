<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser\DTO;

class ToggleStyleRequest
{

    /**
     * @param int $userId
     * @param int $styleId
     */
    public function __construct(
        protected int $userId,
        protected int $styleId
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
    public function getStyleId(): int
    {
        return $this->styleId;
    }
}
