<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use App\Models\Event as EventModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;
use Raspberry\Look\Infrastructure\Repositories\EventRepository;
use Tests\TestCase;

class EventRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetExistentEvent(): void
    {
        $eventModel = EventModel::factory()->create();
        $eventRepository = $this->app->make(EventRepository::class);

        $event = $eventRepository->getById($eventModel->id);

        $this->equalEvent($eventModel, $event);
    }

    public function testGetNonExistentEvent(): void
    {
        $eventModel = EventModel::all()->last();
        $eventRepository = $this->app->make(EventRepository::class);

        $this->expectException(EventNotFoundException::class);
        $eventRepository->getById($eventModel->id + 1000);
    }

    public function testGetEventCollection(): void
    {
        $eventModels = EventModel::factory(5)->create();
        $eventRepository = $this->app->make(EventRepository::class);

        $events = $eventRepository->getCollection($eventModels->map(fn (EventModel $event) => $event->id)->toArray());

        $this->assertNotEmpty($events);

        foreach ($events as $key => $event) {
            $this->equalEvent($eventModels->get($key), $event);
        }
    }

    protected function equalEvent(EventModel $expected, EventInterface $actual): void
    {
        $this->assertEquals($expected->name, $actual->getName()->getValue());
        $this->assertEquals($expected->slug, $actual->getSlug()->getValue());
    }
}
