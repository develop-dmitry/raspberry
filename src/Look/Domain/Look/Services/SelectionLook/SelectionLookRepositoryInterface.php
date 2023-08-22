<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\SelectionLook;

use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;

interface SelectionLookRepositoryInterface
{

    /**
     * @param int $userId
     * @return void
     */
    public function wake(int $userId): void;

    /**
     * @return int|null
     */
    public function getMinTemperature(): ?int;

    /**
     * @param int $minTemperature
     * @return void
     * @throws FailedSavePropertyException
     */
    public function setMinTemperature(int $minTemperature): void;

    /**
     * @return int|null
     */
    public function getMaxTemperature(): ?int;

    /**
     * @param int $maxTemperature
     * @return void
     * @throws FailedSavePropertyException
     */
    public function setMaxTemperature(int $maxTemperature): void;

    /**
     * @return int|null
     * @throws EventNotFoundException
     */
    public function getEventId(): ?int;

    /**
     * @param int $eventId
     * @return void
     * @throws FailedSavePropertyException
     */
    public function setEventId(int $eventId): void;
}
