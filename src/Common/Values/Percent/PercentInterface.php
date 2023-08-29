<?php

namespace Raspberry\Common\Values\Percent;

use Raspberry\Common\Base\Enums\CompareResult;

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
