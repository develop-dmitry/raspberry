<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Event as EventModel;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Base\Pagination\Pagination;
use Raspberry\Common\Base\Pagination\PaginationInterface;
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
        return $this->makeEvents(EventModel::whereIn('id', $ids)->get());
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
     * @inheritDoc
     */
    public function withLooks(int $page, int $perPage): PaginationInterface
    {
        $pagination = EventModel::whereHas('looks')->paginate($perPage, page: $page);

        return new Pagination(
            $this->makeEvents($pagination->getCollection()),
            $pagination->lastPage(),
            $pagination->currentPage(),
            $pagination->perPage()
        );
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $eventId): bool
    {
        return EventModel::find($eventId) !== null;
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
                $this->logger->error('Invalid data in database', ['exception' => $exception->getMessage()]);
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
