<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers;

use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainerInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeOffersService implements WardrobeOffersServiceInterface
{
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getOffers(WardrobeInterface $wardrobe, int $page, int $count): WardrobeOffersContainerInterface
    {
        return $this->wardrobeRepository->getWardrobeOffers($wardrobe, $page, $count);
    }
}
