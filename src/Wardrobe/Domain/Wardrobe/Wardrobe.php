<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;

class Wardrobe implements WardrobeInterface
{
    /**
     * @param IdInterface $userId
     * @param ClothesInterface[] $clothes
     */
    public function __construct(
        protected IdInterface $userId,
        protected array $clothes
    ) {
    }

    /**
     * @return IdInterface
     */
    public function getUserId(): IdInterface
    {
        return $this->userId;
    }

    /**
     * @return ClothesInterface[]
     */
    public function getClothes(): array
    {
        return $this->clothes;
    }
}
