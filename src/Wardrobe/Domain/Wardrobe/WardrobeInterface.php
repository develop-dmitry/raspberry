<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\ClothesAlreadyExistsException;

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

    /**
     * @param ClothesInterface $clothes
     * @return void
     * @throws ClothesAlreadyExistsException
     */
    public function addClothes(ClothesInterface $clothes): void;

    /**
     * @param ClothesInterface $clothes
     * @return void
     */
    public function removeClothes(ClothesInterface $clothes): void;
}
