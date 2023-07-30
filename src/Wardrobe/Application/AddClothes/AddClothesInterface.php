<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\AddClothes;

use Raspberry\Wardrobe\Application\AddClothes\DTO\AddClothesRequest;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\ClothesAlreadyExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;

interface AddClothesInterface
{
    /**
     * @param AddClothesRequest $request
     * @return void
     * @throws UserDoesNotExistsException
     * @throws ClothesAlreadyExistsException
     * @throws ClothesNotFoundException
     */
    public function execute(AddClothesRequest $request): void;
}
