<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\Offers;

use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeInterface;

class OffersService implements OffersServiceInterface
{

    /**
     * @param ClothesRepositoryInterface $clothesRepository
     */
    public function __construct(
        protected ClothesRepositoryInterface $clothesRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getOffers(WardrobeInterface $wardrobe, int $page, int $count): PaginationInterface
    {
        $clothes = $wardrobe->getClothes();
        $clothes = array_map(static fn (ClothesInterface $clothes) => $clothes->getId()->getValue(), $clothes);

        return $this->clothesRepository->whereNotIn($clothes, $page, $count);
    }
}
