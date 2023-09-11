<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\LookUrlGenerator;

use Raspberry\Look\Application\LookUrlGenerator\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\LookUrlGenerator\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\Exceptions\FailedUrlGenerateException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface LookUrlGeneratorInterface
{

    /**
     * @param DetailLookUrlRequest $request
     * @return DetailLookUrlResponse
     * @throws LookNotFoundException
     * @throws FailedUrlGenerateException
     * @throws UnknownProperties
     */
    public function execute(DetailLookUrlRequest $request): DetailLookUrlResponse;
}
