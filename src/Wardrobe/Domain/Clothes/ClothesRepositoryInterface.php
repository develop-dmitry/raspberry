<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Clothes;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;

interface ClothesRepositoryInterface
{
    /**
     * @param int $clothesId
     * @return ClothesInterface
     * @throws ClothesNotFoundException
     * @throws InvalidValueException
     */
    public function getById(int $clothesId): ClothesInterface;

    /**
     * @param array $exclude
     * @param int $page
     * @param int $count
     * @return PaginationInterface
     */
    public function whereNotIn(array $exclude, int $page, int $count): PaginationInterface;
}
