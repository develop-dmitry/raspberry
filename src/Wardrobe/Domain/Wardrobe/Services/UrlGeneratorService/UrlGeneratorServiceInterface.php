<?php

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\UrlGeneratorService;

interface UrlGeneratorServiceInterface
{

    /**
     * @param array $query
     * @return string
     */
    public function getWardrobeUrl(array $query = []): string;

    /**
     * @param array $query
     * @return string
     */
    public function getOffersUrl(array $query = []): string;
}
