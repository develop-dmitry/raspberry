<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\LookUrlGenerator;

use Raspberry\Look\Application\LookUrlGenerator\LookUrlGeneratorInterface;
use Raspberry\Look\Application\LookUrlGenerator\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\LookUrlGenerator\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\UrlGeneratorService;

class LookUrlGeneratorUseCase implements LookUrlGeneratorInterface
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
    public function execute(DetailLookUrlRequest $request): DetailLookUrlResponse
    {
        $look = $this->lookRepository->getById($request->lookId);
        $url = $this->lookUrlGeneratorService->detailLookUrl($look, $request->query);

        return new DetailLookUrlResponse(url: $url->getValue());
    }
}
