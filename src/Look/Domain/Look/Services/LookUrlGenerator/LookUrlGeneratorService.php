<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\LookUrlGenerator;

use Illuminate\Support\Str;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\UrlGenerator\AbstractUrlGenerator;
use Raspberry\Core\Values\Url\Url;
use Raspberry\Core\Values\Url\UrlInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;

class LookUrlGeneratorService extends AbstractUrlGenerator implements LookUrlGeneratorServiceInterface
{

    protected string $pattern = '/look/{id}';

    /**
     * @inheritDoc
     */
    public function makeDetailLookUrl(LookInterface $look, array $query = []): UrlInterface
    {
        $path = Str::replace('{id}', $look->getId()->getValue(), $this->pattern);
        $url = $this->getDomain() . $path;

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        try {
            return new Url($url);
        } catch (InvalidValueException $exception) {
            throw new FailedUrlGenerateException($exception->getMessage());
        }
    }
}
