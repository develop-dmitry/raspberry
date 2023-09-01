<?php

namespace Raspberry\Wardrobe\Application\UrlGenerator\DTO;

class UrlGeneratorResponse
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
