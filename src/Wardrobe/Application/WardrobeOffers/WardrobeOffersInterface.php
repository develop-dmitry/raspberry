<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers;

use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface WardrobeOffersInterface
{
    /**
     * @param WardrobeOffersRequest $request
     * @return WardrobeOffersResponse
     * @throws UserDoesNotExistsException
     * @throws UnknownProperties
     */
    public function execute(WardrobeOffersRequest $request): WardrobeOffersResponse;
}
