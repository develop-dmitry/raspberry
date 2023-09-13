<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\Picker;

use Raspberry\Core\Enums\CompareResult;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\User\UserInterface;

class PickerService implements PickerServiceInterface
{

    /**
     * @param LookRepositoryInterface $lookRepository
     * @param PickerRepositoryInterface $pickerRepository
     * @param UserInterface $user
     */
    public function __construct(
        protected LookRepositoryInterface   $lookRepository,
        protected PickerRepositoryInterface $pickerRepository,
        protected UserInterface             $user
    ) {
    }

    /**
     * @inheritDoc
     */
    public function pick(): array
    {
        $looks = $this->lookRepository->findForSelection(
            $this->minTemperature(),
            $this->maxTemperature(),
            $this->pickerRepository->getEventId()
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
            $percentA = $a->pickerScore($this->user);
            $percentB = $b->pickerScore($this->user);

            return $percentB->compare($percentA)->value;
        } catch (InvalidValueException) {
            return CompareResult::Equal->value;
        }
    }

    protected function minTemperature(): int
    {
        return $this->pickerRepository->getTemperature() - 10;
    }

    protected function maxTemperature(): int
    {
        return $this->pickerRepository->getTemperature() + 10;
    }
}
