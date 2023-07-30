<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers;

use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainerInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeInterface;

interface WardrobeOffersServiceInterface
{
    /**
     * @param WardrobeInterface $wardrobe
     * @param int $page
     * @param int $count
     * @return WardrobeOffersContainerInterface
     */
    public function getOffers(WardrobeInterface $wardrobe, int $page, int $count): WardrobeOffersContainerInterface;
}
