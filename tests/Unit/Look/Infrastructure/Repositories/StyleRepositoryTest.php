<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use App\Models\Style as StyleModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Psr\Log\LoggerInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Infrastructure\Repositories\StyleRepository;
use Tests\TestCase;

class StyleRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetCollection(): void
    {
        $stylesModels = StyleModel::factory(3)->create();
        $styleRepository = new StyleRepository($this->app->make(LoggerInterface::class));

        $styles = $styleRepository->getCollection($stylesModels->pluck('id')->toArray());

        $this->assertCount($stylesModels->count(), $styles);
    }

    public function testGetGetById(): void
    {
        $styleModel = StyleModel::factory(1)->create()->first();
        $styleRepository = new StyleRepository($this->app->make(LoggerInterface::class));

        $style = $styleRepository->getById($styleModel->id);

        $this->equalStyle($styleModel, $style);
    }

    protected function equalStyle(StyleModel $expected, StyleInterface $actual): void
    {
        $this->assertEquals($expected->id, $actual->getId()->getValue());
        $this->assertEquals($expected->name, $actual->getName()->getValue());
    }
}
