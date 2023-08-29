<?php

namespace Raspberry\Common\Values\Percent;

interface PercentInterface
{

    /**
     * @return float
     */
    public function getValue(): float;

    /**
     * Return 0 if value equals
     * Return 1 if value more
     * Return -1 if value less
     *
     * @param PercentInterface $percent
     * @return int
     */
    public function compare(PercentInterface $percent): int;
}
