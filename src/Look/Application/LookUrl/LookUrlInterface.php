<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\LookUrl;

use Raspberry\Look\Application\LookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\LookUrl\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\Exceptions\FailedUrlGenerateException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface LookUrlInterface
{

    /**
     * @param DetailLookUrlRequest $request
     * @return DetailLookUrlResponse
     * @throws LookNotFoundException
     * @throws FailedUrlGenerateException
     * @throws UnknownProperties
     */
    public function generateDetailUrl(DetailLookUrlRequest $request): DetailLookUrlResponse;
}
