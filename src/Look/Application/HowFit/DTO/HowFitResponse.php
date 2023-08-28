<?php

namespace Raspberry\Look\Application\HowFit\DTO;

class HowFitResponse
{

    /**
     * @param float $percent
     */
    public function __construct(
        protected float $percent
    ) {
    }

    /**
     * @return int
     */
    public function getPercent(): float
    {
        return $this->percent;
    }
}
