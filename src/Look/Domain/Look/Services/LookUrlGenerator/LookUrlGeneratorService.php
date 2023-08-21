<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\LookUrlGenerator;

use Illuminate\Support\Str;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Url\Url;
use Raspberry\Common\Values\Url\UrlInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;

class LookUrlGeneratorService implements LookUrlGeneratorServiceInterface
{

    protected string $pattern = 'look/{id}';

    /**
     * @param LookInterface $look
     * @inheritDoc
     */
    public function makeDetailLookUrl(LookInterface $look): UrlInterface
    {
        $path = Str::replace('{id}', $look->getId()->getValue(), $this->pattern);
        $url = "{$this->getDomain()}/$path";

        try {
            return new Url($url);
        } catch (InvalidValueException $exception) {
            throw new FailedUrlGenerateException($exception->getMessage());
        }
    }

    protected function getDomain(): string
    {
        if (config('app.env') === 'production') {
            return config('app.url');
        }

        return config('app.asset_url');
    }
}
