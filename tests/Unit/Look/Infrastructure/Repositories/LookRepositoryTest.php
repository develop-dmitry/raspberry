<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use App\Models\Event as EventModel;
use Illuminate\Database\Eloquent\Builder;
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

    public function testFindForSelection(): void
    {
        $event = EventModel::whereHas('looks', static function (Builder $builder) {
            $builder->where('min_temperature', '>=', -30);
            $builder->where('max_temperature', '<=', 30);

            return $builder;
        })->first();
        $lookModels = LookModel::where('min_temperature', '>=', -30)
            ->where('max_temperature', '<=', 30)
            ->whereHas('events', fn (Builder $builder) => $builder->where('id', $event->id))
            ->get();
        $lookRepository = $this->app->make(LookRepository::class);

        $looks = $lookRepository->findForSelection(-30, 30, $event->id);

        $this->assertCount($lookModels->count(), $looks);
    }
}
