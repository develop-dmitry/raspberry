<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;

interface WardrobeInterface
{
    /**
     * @return IdInterface
     */
    public function getUserId(): IdInterface;

    /**
     * @return ClothesInterface[]
     */
    public function getClothes(): array;
}
