<?php

namespace Raspberry\Wardrobe\Application\UrlGenerator;

use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorRequest;
use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorResponse;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\UrlGeneratorService\UrlGeneratorServiceInterface;

class UrlGeneratorUseCase implements UrlGeneratorInterface
{

    /**
     * @param UrlGeneratorServiceInterface $urlGeneratorService
     */
    public function __construct(
        protected UrlGeneratorServiceInterface $urlGeneratorService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getWardrobeUrl(UrlGeneratorRequest $request): UrlGeneratorResponse
    {
        $url = $this->urlGeneratorService->getWardrobeUrl($request->query);

        return new UrlGeneratorResponse(url: $url);
    }

    /**
     * @inheritDoc
     */
    public function getWardrobeOffersUrl(UrlGeneratorRequest $request): UrlGeneratorResponse
    {
        $url = $this->urlGeneratorService->getOffersUrl($request->query);

        return new UrlGeneratorResponse(url: $url);
    }
}
