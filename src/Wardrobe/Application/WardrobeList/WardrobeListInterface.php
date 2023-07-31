<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList;

use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListRequest;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListResponse;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;

interface WardrobeListInterface
{
    /**
     * @param WardrobeListRequest $request
     * @return WardrobeListResponse
     * @throws UserDoesNotExistsException
     */
    public function execute(WardrobeListRequest $request): WardrobeListResponse;
}
