<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer;

use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;

interface WardrobeOffersContainerInterface
{
    /**
     * @return ClothesInterface[]
     */
    public function getClothes(): array;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @return int
     */
    public function getTotal(): int;
}
