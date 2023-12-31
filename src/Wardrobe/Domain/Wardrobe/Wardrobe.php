<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\ClothesAlreadyExistsException;

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

    public function removeClothes(ClothesInterface $clothes): void
    {
        foreach ($this->clothes as $key => $item) {
            if ($item->getId()->getValue() === $clothes->getId()->getValue()) {
                unset($this->clothes[$key]);
                break;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function addClothes(ClothesInterface $clothes): void
    {
        if ($this->hasClothes($clothes)) {
            throw new ClothesAlreadyExistsException();
        }

        $this->clothes[] = $clothes;
    }

    protected function hasClothes(ClothesInterface $clothes): bool
    {
        foreach ($this->clothes as $item) {
            if ($item->getId()->getValue() === $clothes->getId()->getValue()) {
                return true;
            }
        }

        return false;
    }
}
