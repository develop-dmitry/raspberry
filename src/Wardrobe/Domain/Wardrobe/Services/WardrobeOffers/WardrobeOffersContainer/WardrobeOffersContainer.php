<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer;

use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;

class WardrobeOffersContainer implements WardrobeOffersContainerInterface
{
    /**
     * @param ClothesInterface[] $clothes
     * @param int $page
     * @param int $count
     * @param int $total
     */
    public function __construct(
        protected array $clothes,
        protected int $page,
        protected int $count,
        protected int $total
    ) {
    }

    /**
     * @return array
     */
    public function getClothes(): array
    {
        return $this->clothes;
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

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
