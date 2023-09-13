<?php

namespace Raspberry\Core\Values\Percent;

use Raspberry\Core\Enums\CompareResult;

interface PercentInterface
{

    /**
     * @return float
     */
    public function getValue(): float;

    /**
     * @param PercentInterface $percent
     * @return CompareResult
     */
    public function compare(PercentInterface $percent): CompareResult;
}
