<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList;

use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeItem;
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
        $wardrobe = $this->wardrobeRepository->getWardrobe($request->getUserId());
        $items = [];

        foreach ($wardrobe->getClothes() as $clothes) {
            $items[] = $this->convertClothes($clothes);
        }

        return new WardrobeListResponse($items);
    }

    /**
     * @param ClothesInterface $clothes
     * @return WardrobeItem
     */
    protected function convertClothes(ClothesInterface $clothes): WardrobeItem
    {
        return new WardrobeItem(
            $clothes->getId()->getValue(),
            $clothes->getName()->getValue(),
            $clothes->getSlug()->getValue(),
            $clothes->getPhoto()->getValue()
        );
    }
}
