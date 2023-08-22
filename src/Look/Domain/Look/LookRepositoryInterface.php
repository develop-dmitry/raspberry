<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;

interface LookRepositoryInterface
{
    /**
     * @param int $id
     * @return LookInterface
     * @throws LookNotFoundException
     */
    public function getById(int $id): LookInterface;

    /**
     * @param int $minTemperature
     * @param int $maxTemperature
     * @param int $eventId
     * @return LookInterface[]
     */
    public function findForSelection(int $minTemperature, int $maxTemperature, int $eventId): array;
}
