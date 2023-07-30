<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainerInterface;

interface WardrobeRepositoryInterface
{
    /**
     * @param int $userId
     * @return WardrobeInterface
     * @throws UserDoesNotExistsException
     */
    public function getWardrobe(int $userId): WardrobeInterface;

    /**
     * @param WardrobeInterface $wardrobe
     * @return void
     * @throws UserDoesNotExistsException
     */
    public function saveWardrobe(WardrobeInterface $wardrobe): void;

    /**
     * @param WardrobeInterface $wardrobe
     * @param int $page
     * @param int $count
     * @return WardrobeOffersContainerInterface
     */
    public function getWardrobeOffers(
        WardrobeInterface $wardrobe,
        int $page,
        int $count
    ): WardrobeOffersContainerInterface;
}
