<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\RemoveClothes;

use Raspberry\Wardrobe\Application\RemoveClothes\DTO\RemoveClothesRequest;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;

interface RemoveClothesInterface
{
    /**
     * @param RemoveClothesRequest $request
     * @return void
     * @throws UserDoesNotExistsException
     * @throws ClothesNotFoundException
     */
    public function execute(RemoveClothesRequest $request): void;
}
