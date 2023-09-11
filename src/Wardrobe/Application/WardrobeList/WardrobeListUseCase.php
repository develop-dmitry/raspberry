<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList;

use Raspberry\Wardrobe\Application\WardrobeList\DTO\ClothesData;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListRequest;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListResponse;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeListUseCase implements WardrobeListInterface
{
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(WardrobeListRequest $request): WardrobeListResponse
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($request->userId);
        $items = $wardrobe->getClothes();
        $items = array_map(static fn (ClothesInterface $clothes) => ClothesData::fromDomain($clothes), $items);

        return new WardrobeListResponse(items: $items);
    }
}
