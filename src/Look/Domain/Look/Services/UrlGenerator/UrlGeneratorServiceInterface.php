<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\UrlGenerator;

use Raspberry\Core\Values\Url\UrlInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\Exceptions\FailedUrlGenerateException;

interface UrlGeneratorServiceInterface
{

    /**
     * @param LookInterface $look
     * @param array $query
     * @return UrlInterface
     * @throws FailedUrlGenerateException
     */
    public function detailLookUrl(LookInterface $look, array $query = []): UrlInterface;
}
