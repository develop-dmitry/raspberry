<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use App\Models\Style as StyleModel;
use Psr\Log\LoggerInterface;
use Raspberry\Look\Infrastructure\Repositories\StyleRepository;
use Tests\TestCase;

class StyleRepositoryTest extends TestCase
{

    public function testGetCollection(): void
    {
        $stylesModels = StyleModel::orderBy('id', 'desc')->limit(3)->get();
        $styleRepository = new StyleRepository($this->app->make(LoggerInterface::class));

        $styles = $styleRepository->getCollection($stylesModels->pluck('id')->toArray());

        $this->assertCount($stylesModels->count(), $styles);
    }
}
