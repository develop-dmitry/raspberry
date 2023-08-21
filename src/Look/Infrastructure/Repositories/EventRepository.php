<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Event as EventModel;
use Illuminate\Database\Eloquent\Collection;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Look\Domain\Event\Event;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;

class EventRepository implements EventRepositoryInterface
{

    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCollection(array $ids): array
    {
        return $this->makeEvents(EventModel::where('id', $ids)->get());
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): EventInterface
    {
        $eventModel = EventModel::find($id);

        if (!$eventModel) {
            throw new EventNotFoundException();
        }

        return $this->makeEvent($eventModel);
    }

    /**
     * @param Collection $models
     * @return EventInterface[]
     */
    protected function makeEvents(Collection $models): array
    {
        $events = [];

        foreach ($models as $model) {
            try {
                $events[] = $this->makeEvent($model);
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid data in database');
            }
        }

        return $events;
    }

    /**
     * @param EventModel $event
     * @return EventInterface
     * @throws InvalidValueException
     */
    protected function makeEvent(EventModel $event): EventInterface
    {
        return new Event(
            new Id($event->id),
            new Name($event->name),
            new Slug($event->slug)
        );
    }
}
