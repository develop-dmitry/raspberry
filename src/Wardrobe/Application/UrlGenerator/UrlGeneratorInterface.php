<?php

namespace Raspberry\Wardrobe\Application\UrlGenerator;

use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorRequest;
use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorResponse;

interface UrlGeneratorInterface
{

    /**
     * @param UrlGeneratorRequest $request
     * @return UrlGeneratorResponse
     */
    public function getWardrobeUrl(UrlGeneratorRequest $request): UrlGeneratorResponse;

    /**
     * @param UrlGeneratorRequest $request
     * @return UrlGeneratorResponse
     */
    public function getWardrobeOffersUrl(UrlGeneratorRequest $request): UrlGeneratorResponse;
}
