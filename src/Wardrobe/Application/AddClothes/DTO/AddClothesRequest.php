<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\AddClothes\DTO;

class AddClothesRequest
{
    public function __construct(
        protected int $userId,
        protected int $clothesId
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
    public function getClothesId(): int
    {
        return $this->clothesId;
    }
}
