<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\UrlGenerator;

use Illuminate\Support\Str;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\UrlGenerator\AbstractUrlGenerator;
use Raspberry\Core\Values\Url\Url;
use Raspberry\Core\Values\Url\UrlInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\Exceptions\FailedUrlGenerateException;

class UrlGeneratorService extends AbstractUrlGenerator implements UrlGeneratorServiceInterface
{

    /**
     * @inheritDoc
     */
    public function detailLookUrl(LookInterface $look, array $query = []): UrlInterface
    {
        $id = $look->getId()->getValue();
        $path = "/look/$id";

        try {
            return new Url($this->buildUrl($path, $query));
        } catch (InvalidValueException $exception) {
            throw new FailedUrlGenerateException($exception->getMessage());
        }
    }
}
