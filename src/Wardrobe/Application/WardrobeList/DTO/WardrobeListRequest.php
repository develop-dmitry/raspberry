<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList\DTO;

class WardrobeListRequest
{
    /**
     * @param int $userId
     */
    public function __construct(
        protected int $userId
    ) {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
