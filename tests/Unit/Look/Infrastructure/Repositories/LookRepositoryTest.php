<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use Raspberry\Look\Infrastructure\Repositories\LookRepository;
use Tests\TestCase;
use App\Models\Look as LookModel;

class LookRepositoryTest extends TestCase
{

    public function testGetById(): void
    {
        $lookModel = LookModel::factory()->create()->first();
        $lookRepository = $this->app->make(LookRepository::class);

        $this->expectNotToPerformAssertions();
        $lookRepository->getById($lookModel->id);
    }

    public function testFindByTemperature(): void
    {
        $lookModels = LookModel::where('min_temperature', '>=', -30)
            ->where('max_temperature', '<=', 30)
            ->get();
        $lookRepository = $this->app->make(LookRepository::class);

        $looks = $lookRepository->findByTemperature(-30, 30);

        $this->assertCount($lookModels->count(), $looks);
    }
}
