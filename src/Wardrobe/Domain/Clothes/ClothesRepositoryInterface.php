<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Clothes;

use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;

interface ClothesRepositoryInterface
{
    /**
     * @param int $clothesId
     * @return ClothesInterface
     * @throws ClothesNotFoundException
     */
    public function getClothesById(int $clothesId): ClothesInterface;
}
