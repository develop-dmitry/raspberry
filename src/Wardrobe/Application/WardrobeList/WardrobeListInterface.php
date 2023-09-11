<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList;

use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListRequest;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListResponse;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface WardrobeListInterface
{
    /**
     * @param WardrobeListRequest $request
     * @return WardrobeListResponse
     * @throws UserDoesNotExistsException
     * @throws UnknownProperties
     */
    public function execute(WardrobeListRequest $request): WardrobeListResponse;
}
