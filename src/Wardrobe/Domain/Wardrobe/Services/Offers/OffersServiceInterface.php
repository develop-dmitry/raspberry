<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\Offers;

use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeInterface;

interface OffersServiceInterface
{

    /**
     * @param WardrobeInterface $wardrobe
     * @param int $page
     * @param int $count
     * @return PaginationInterface
     */
    public function getOffers(WardrobeInterface $wardrobe, int $page, int $count): PaginationInterface;
}
