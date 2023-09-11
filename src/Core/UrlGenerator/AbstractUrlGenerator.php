<?php

namespace Raspberry\Core\UrlGenerator;

abstract class AbstractUrlGenerator
{

    public function getDomain(): string
    {
        if (config('app.env') === 'production') {
            return config('app.url');
        }

        return config('app.asset_url');
    }
}