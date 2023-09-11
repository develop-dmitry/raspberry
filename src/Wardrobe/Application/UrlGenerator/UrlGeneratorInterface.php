<?php

namespace Raspberry\Wardrobe\Application\UrlGenerator;

use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorRequest;
use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface UrlGeneratorInterface
{

    /**
     * @param UrlGeneratorRequest $request
     * @return UrlGeneratorResponse
     * @throws UnknownProperties
     */
    public function getWardrobeUrl(UrlGeneratorRequest $request): UrlGeneratorResponse;

    /**
     * @param UrlGeneratorRequest $request
     * @return UrlGeneratorResponse
     * @throws UnknownProperties
     */
    public function getWardrobeOffersUrl(UrlGeneratorRequest $request): UrlGeneratorResponse;
}
