<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl;

use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface DetailLookUrlInterface
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
