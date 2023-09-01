<?php

namespace Tests\Unit\Wardrobe\Domain\Wardrobe\Services;

use Raspberry\Wardrobe\Domain\Wardrobe\Services\UrlGeneratorService\UrlGeneratorService;
use Tests\TestCase;

class UrlGeneratorServiceTest extends TestCase
{

    public function testGetWardrobeUrl(): void
    {
        $urlGenerator = new UrlGeneratorService();

        $this->assertEquals($this->getUrl('/wardrobe'), $urlGenerator->getWardrobeUrl());
    }

    public function testGetWardrobeUrlWithQuery(): void
    {
        $urlGenerator = new UrlGeneratorService();
        $query = ['param1' => 'value1', 'param2' => 'value2'];

        $url = $urlGenerator->getWardrobeUrl($query);

        $this->assertEquals($this->getUrl('/wardrobe?param1=value1&param2=value2'), $url);
    }

    public function testGetOffersUrl(): void
    {
        $urlGenerator = new UrlGeneratorService();

        $this->assertEquals($this->getUrl('/wardrobe/offers'), $urlGenerator->getOffersUrl());
    }

    public function testGetOffersUrlWithQuery(): void
    {
        $urlGenerator = new UrlGeneratorService();
        $query = ['param1' => 'value1', 'param2' => 'value2'];

        $url = $urlGenerator->getOffersUrl($query);

        $this->assertEquals($this->getUrl('/wardrobe/offers?param1=value1&param2=value2'), $url);
    }

    protected function getUrl(string $url): string
    {
        if (config('app.env') === 'production') {
            return config('app.url') . $url;
        }

        return config('app.asset_url') . $url;
    }
}
