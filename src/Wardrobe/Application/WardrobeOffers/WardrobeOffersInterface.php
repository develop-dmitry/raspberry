<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers;

use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;

interface WardrobeOffersInterface
{
    /**
     * @param WardrobeOffersRequest $request
     * @return WardrobeOffersResponse
     * @throws UserDoesNotExistsException
     */
    public function execute(WardrobeOffersRequest $request): WardrobeOffersResponse;
}
