<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\RemoveClothes;

use Raspberry\Wardrobe\Application\RemoveClothes\DTO\RemoveClothesRequest;
use Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class RemoveClothesUseCase implements RemoveClothesInterface
{
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository,
        protected ClothesRepositoryInterface $clothesRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(RemoveClothesRequest $request): void
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($request->getUserId());
        $clothes = $this->clothesRepository->getClothesById($request->getClothesId());

        $wardrobe->removeClothes($clothes);
        $this->wardrobeRepository->saveWardrobe($wardrobe);
    }
}
