<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\LookUrlGenerator;

use Raspberry\Common\Values\Url\UrlInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;

interface LookUrlGeneratorServiceInterface
{

    /**
     * @param LookInterface $look
     * @return UrlInterface
     * @throws FailedUrlGenerateException
     */
    public function makeDetailLookUrl(LookInterface $look): UrlInterface;
}
