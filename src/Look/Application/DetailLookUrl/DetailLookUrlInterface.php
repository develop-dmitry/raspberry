<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl;

use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;

interface DetailLookUrlInterface
{

    /**
     * @param DetailLookUrlRequest $request
     * @return DetailLookUrlResponse
     * @throws LookNotFoundException
     * @throws FailedUrlGenerateException
     */
    public function execute(DetailLookUrlRequest $request): DetailLookUrlResponse;
}
