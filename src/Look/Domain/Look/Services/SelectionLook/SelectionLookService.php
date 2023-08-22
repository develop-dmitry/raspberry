<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\SelectionLook;

use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;

class SelectionLookService implements SelectionLookServiceInterface
{

    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected int $minTemperature,
        protected int $maxTemperature,
        protected EventInterface $event
    ) {
    }

    /**
     * @inheritDoc
     */
    public function selection(): array
    {
        return $this->lookRepository->findForSelection(
            $this->minTemperature,
            $this->maxTemperature,
            $this->event->getId()->getValue()
        );
    }
}
