<?php

namespace Raspberry\Core\UrlGenerator;

abstract class AbstractUrlGenerator
{

    protected function getDomain(): string
    {
        if (config('app.env') === 'production') {
            return config('app.url');
        }

        return config('app.asset_url');
    }

    protected function buildUrl(string $path, array $query): string
    {
        $url = $this->getDomain() . $path;

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }
}
