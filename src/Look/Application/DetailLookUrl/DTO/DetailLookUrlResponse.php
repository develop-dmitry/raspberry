<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl\DTO;

class DetailLookUrlResponse
{

    /**
     * @param string $url
     */
    public function __construct(
        protected string $url
    ) {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
