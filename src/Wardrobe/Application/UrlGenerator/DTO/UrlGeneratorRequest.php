<?php

namespace Raspberry\Wardrobe\Application\UrlGenerator\DTO;

class UrlGeneratorRequest
{

    /**
     * @param array $query
     */
    public function __construct(
        protected array $query = []
    ) {
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }
}
