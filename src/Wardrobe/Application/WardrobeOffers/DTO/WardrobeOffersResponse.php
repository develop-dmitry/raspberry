<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers\DTO;

class WardrobeOffersResponse
{
    /**
     * @param WardrobeOffer[] $offers
     * @param int $page
     * @param int $total
     * @param int $count
     */
    public function __construct(
        protected array $offers,
        protected int $page,
        protected int $total,
        protected int $count
    ) {
    }

    /**
     * @return WardrobeOffer[]
     */
    public function getOffers(): array
    {
        return $this->offers;
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
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}
