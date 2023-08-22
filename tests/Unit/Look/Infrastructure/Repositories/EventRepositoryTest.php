<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use App\Models\Event as EventModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Psr\Log\LoggerInterface;
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
        $eventRepository = new EventRepository($this->app->make(LoggerInterface::class));

        $event = $eventRepository->getById($eventModel->id);

        $this->equalEvent($eventModel, $event);
    }

    public function testGetNonExistentEvent(): void
    {
        $eventModel = EventModel::all()->last();
        $eventRepository = new EventRepository($this->app->make(LoggerInterface::class));

        $this->expectException(EventNotFoundException::class);
        $eventRepository->getById($eventModel->id + 1000);
    }

    public function testGetEventCollection(): void
    {
        $eventModels = EventModel::factory(5)->create();
        $eventRepository = new EventRepository($this->app->make(LoggerInterface::class));

        $events = $eventRepository->getCollection($eventModels->map(fn (EventModel $event) => $event->id)->toArray());

        $this->assertNotEmpty($events);

        foreach ($events as $key => $event) {
            $this->equalEvent($eventModels->get($key), $event);
        }
    }

    public function testPagination(): void
    {
        $modelPagination = EventModel::paginate(10, page: 1);
        $eventRepository = new EventRepository($this->app->make(LoggerInterface::class));

        $pagination = $eventRepository->pagination(1, 10);

        foreach ($pagination->getItems() as $key => $item) {
            $this->equalEvent($modelPagination->get($key), $item);
        }
    }

    protected function equalEvent(EventModel $expected, EventInterface $actual): void
    {
        $this->assertEquals($expected->name, $actual->getName()->getValue());
        $this->assertEquals($expected->slug, $actual->getSlug()->getValue());
    }
}
