<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\LookUrl;

use Raspberry\Look\Application\LookUrl\LookUrlInterface;
use Raspberry\Look\Application\LookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\LookUrl\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\UrlGeneratorService;

class LookUrlUseCase implements LookUrlInterface
{

    /**
     * @param LookRepositoryInterface $lookRepository
     * @param UrlGeneratorService $lookUrlGeneratorService
     */
    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected UrlGeneratorService $lookUrlGeneratorService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function generateDetailUrl(DetailLookUrlRequest $request): DetailLookUrlResponse
    {
        $look = $this->lookRepository->getById($request->lookId);
        $url = $this->lookUrlGeneratorService->detailLookUrl($look, $request->query);

        return new DetailLookUrlResponse(url: $url->getValue());
    }
}
