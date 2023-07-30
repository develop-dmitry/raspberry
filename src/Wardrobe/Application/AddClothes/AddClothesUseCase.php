<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\AddClothes;

use Raspberry\Wardrobe\Application\AddClothes\DTO\AddClothesRequest;
use Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class AddClothesUseCase implements AddClothesInterface
{
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository,
        protected ClothesRepositoryInterface $clothesRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(AddClothesRequest $request): void
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($request->getUserId());
        $clothes = $this->clothesRepository->getClothesById($request->getClothesId());

        $wardrobe->addClothes($clothes);
        $this->wardrobeRepository->saveWardrobe($wardrobe);
    }
}
