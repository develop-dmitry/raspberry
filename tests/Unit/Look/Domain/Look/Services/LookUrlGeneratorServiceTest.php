<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Domain\Look\Services;

use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Look\Look;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\LookUrlGeneratorService;
use Tests\TestCase;

class LookUrlGeneratorServiceTest extends TestCase
{

    public function testDetailUrlGenerate(): void
    {
        $look = new Look(
            new Id(1),
            new Name('test'),
            new Slug('test'),
            new Photo('/test.png'),
            [],
            new Temperature(-10),
            new Temperature(10),
            []
        );
        $urlGenerator = $this->app->make(LookUrlGeneratorService::class);

        $url = $urlGenerator->makeDetailLookUrl($look);

        $this->assertEquals(
            $this->getDomain() . '/look/1',
            $url->getValue()
        );
    }

    public function testDetailUrlGenerateWithQuery(): void
    {
        $look = new Look(
            new Id(1),
            new Name('test'),
            new Slug('test'),
            new Photo('/test.png'),
            [],
            new Temperature(-10),
            new Temperature(10),
            []
        );
        $urlGenerator = $this->app->make(LookUrlGeneratorService::class);

        $url = $urlGenerator->makeDetailLookUrl($look, ['param1' => 'value1', 'param2' => 'value2']);

        $this->assertEquals(
            $this->getDomain() . '/look/1?param1=value1&param2=value2',
            $url->getValue()
        );
    }

    protected function getDomain(): string
    {
        if (config('app.env') === 'production') {
            return config('app.url');
        }

        return config('app.asset_url');
    }
}
