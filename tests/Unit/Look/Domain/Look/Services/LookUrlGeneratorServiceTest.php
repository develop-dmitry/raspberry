<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Domain\Look\Services;

use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Photo\Photo;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Common\Values\Temperature\Temperature;
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
            new Temperature(10)
        );
        $urlGenerator = $this->app->make(LookUrlGeneratorService::class);

        $url = $urlGenerator->makeDetailLookUrl($look);

        $this->assertEquals(
            config('app.asset_url') . '/look/1',
            $url->getValue()
        );
    }
}
