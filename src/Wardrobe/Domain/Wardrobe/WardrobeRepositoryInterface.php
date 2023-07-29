<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Wardrobe;

use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\WardrobeNotFoundException;

interface WardrobeRepositoryInterface
{
    /**
     * @param int $userId
     * @return WardrobeInterface
     * @throws UserDoesNotExistsException
     * @throws WardrobeNotFoundException
     */
    public function getWardrobe(int $userId): WardrobeInterface;
}
