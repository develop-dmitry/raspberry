<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl;

use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlInterface;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\LookUrlGeneratorService;

class DetailLookUrlUseCase implements DetailLookUrlInterface
{

    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected LookUrlGeneratorService $lookUrlGeneratorService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(DetailLookUrlRequest $request): DetailLookUrlResponse
    {
        $look = $this->lookRepository->getById($request->getLookId());
        $url = $this->lookUrlGeneratorService->makeDetailLookUrl($look);

        return new DetailLookUrlResponse($url->getValue());
    }
}
