<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Event;

use Raspberry\Common\Pagination\PaginationInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;

interface EventRepositoryInterface
{

    /**
     * @param array $ids
     * @return EventInterface[]
     */
    public function getCollection(array $ids): array;

    /**
     * @param int $id
     * @return EventInterface
     * @throws EventNotFoundException
     * @throws InvalidValueException
     */
    public function getById(int $id): EventInterface;

    /**
     * @param int $page
     * @param int $perPage
     * @return PaginationInterface
     */
    public function pagination(int $page, int $perPage): PaginationInterface;

    /**
     * @param int $eventId
     * @return bool
     */
    public function isExists(int $eventId): bool;
}
