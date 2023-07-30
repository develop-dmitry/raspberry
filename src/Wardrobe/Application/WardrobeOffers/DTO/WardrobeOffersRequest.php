<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers\DTO;

class WardrobeOffersRequest
{
    /**
     * @param int $userId
     * @param int $page
     * @param int $count
     */
    public function __construct(
        protected int $userId,
        protected int $page,
        protected int $count
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
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}
