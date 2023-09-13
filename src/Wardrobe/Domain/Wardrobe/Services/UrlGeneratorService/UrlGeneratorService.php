<?php

namespace Raspberry\Wardrobe\Domain\Wardrobe\Services\UrlGeneratorService;

use Raspberry\Core\UrlGenerator\AbstractUrlGenerator;

class UrlGeneratorService extends AbstractUrlGenerator implements UrlGeneratorServiceInterface
{
    public function getWardrobeUrl(array $query = []): string
    {
        $url = '/wardrobe';

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $this->getDomain() . $url;
    }

    public function getOffersUrl(array $query = []): string
    {
        $url = '/wardrobe/offers';

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $this->getDomain() . $url;
    }
}
