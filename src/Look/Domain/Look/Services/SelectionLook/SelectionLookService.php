<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\SelectionLook;

use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;

class SelectionLookService implements SelectionLookServiceInterface
{

    protected SelectionLookRepositoryInterface $selectionLookRepository;

    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        int $userId
    ) {
        $this->selectionLookRepository = new SelectionLookRepository($userId);
    }

    /**
     * @inheritDoc
     */
    public function selection(): array
    {
        return $this->lookRepository->findForSelection(
            $this->minTemperature(),
            $this->maxTemperature(),
            $this->selectionLookRepository->getEventId()
        );
    }

    protected function minTemperature(): int
    {
        return $this->selectionLookRepository->getTemperature() - 10;
    }

    protected function maxTemperature(): int
    {
        return $this->selectionLookRepository->getTemperature() + 10;
    }
}
