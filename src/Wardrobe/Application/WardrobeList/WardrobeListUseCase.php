<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList;

use Raspberry\Wardrobe\Application\WardrobeList\DTO\ClothesData;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListRequest;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListResponse;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeListUseCase implements WardrobeListInterface
{

    /**
     * @param WardrobeRepositoryInterface $wardrobeRepository
     */
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(WardrobeListRequest $request): WardrobeListResponse
    {
        $items = $this->getWardrobeClothes($request->userId);
        $items = array_map(static fn (ClothesInterface $clothes) => ClothesData::fromDomain($clothes), $items);

        return new WardrobeListResponse(items: $items);
    }

    /**
     * @return ClothesInterface[]
     * @throws UserDoesNotExistsException
     */
    protected function getWardrobeClothes(int $userId): array
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($userId);

        return $wardrobe->getClothes();
    }
}
