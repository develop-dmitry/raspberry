<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook\DTO;

class SelectionLookRequest
{

    /**
     * @param int $minTemperature
     * @param int $maxTemperature
     */
    public function __construct(
        protected int $minTemperature,
        protected int $maxTemperature
    ) {
    }

    /**
     * @return int
     */
    public function getMinTemperature(): int
    {
        return $this->minTemperature;
    }

    /**
     * @return int
     */
    public function getMaxTemperature(): int
    {
        return $this->maxTemperature;
    }
}
