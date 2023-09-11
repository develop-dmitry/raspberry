<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers;

use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\ClothesData;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainerInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersServiceInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeOffersUseCase implements WardrobeOffersInterface
{
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository,
        protected WardrobeOffersServiceInterface $wardrobeOffersService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(WardrobeOffersRequest $request): WardrobeOffersResponse
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($request->userId);
        $offers = $this->wardrobeOffersService->getOffers($wardrobe, $request->page, $request->count);

        $items = $offers->getClothes();
        $items = array_map(static fn (ClothesInterface $clothes) => ClothesData::fromDomain($clothes), $items);

        return new WardrobeOffersResponse(
            items: $items,
            page: $offers->getPage(),
            total: $offers->getTotal(),
            count: $offers->getCount()
        );
    }
}
