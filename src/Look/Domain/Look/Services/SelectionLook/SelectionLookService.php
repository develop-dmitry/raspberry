<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\SelectionLook;

use Raspberry\Common\Base\Enums\CompareResult;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\User\UserInterface;

class SelectionLookService implements SelectionLookServiceInterface
{

    /**
     * @param LookRepositoryInterface $lookRepository
     * @param SelectionLookRepositoryInterface $selectionLookRepository
     * @param UserInterface $user
     */
    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected SelectionLookRepositoryInterface $selectionLookRepository,
        protected UserInterface $user
    ) {
    }

    /**
     * @inheritDoc
     */
    public function selection(): array
    {
        $looks = $this->lookRepository->findForSelection(
            $this->minTemperature(),
            $this->maxTemperature(),
            $this->selectionLookRepository->getEventId()
        );

        usort($looks, [$this, 'compareLooks']);

        return $looks;
    }

    /**
     * @param LookInterface $a
     * @param LookInterface $b
     * @return int
     */
    protected function compareLooks(LookInterface $a, LookInterface $b): int
    {
        try {
            $percentA = $a->howFit($this->user);
            $percentB = $b->howFit($this->user);

            return $percentB->compare($percentA)->value;
        } catch (InvalidValueException) {
            return CompareResult::Equal->value;
        }
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
