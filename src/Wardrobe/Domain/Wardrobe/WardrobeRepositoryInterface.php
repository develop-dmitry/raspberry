<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;

interface WardrobeRepositoryInterface
{

    /**
     * @param int $userId
     * @return WardrobeInterface
     * @throws UserDoesNotExistsException
     */
    public function getWardrobe(int $userId): WardrobeInterface;

    /**
     * @param WardrobeInterface $wardrobe
     * @return void
     * @throws UserDoesNotExistsException
     */
    public function saveWardrobe(WardrobeInterface $wardrobe): void;
}
