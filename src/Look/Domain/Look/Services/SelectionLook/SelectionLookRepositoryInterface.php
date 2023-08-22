<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\SelectionLook;

use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;

interface SelectionLookRepositoryInterface
{

    /**
     * @return int|null
     */
    public function getTemperature(): ?int;

    /**
     * @param int $temperature
     * @return void
     * @throws FailedSavePropertyException
     */
    public function setTemperature(int $temperature): void;

    /**
     * @return int|null
     */
    public function getEventId(): ?int;

    /**
     * @param int $eventId
     * @return void
     * @throws FailedSavePropertyException
     */
    public function setEventId(int $eventId): void;
}
