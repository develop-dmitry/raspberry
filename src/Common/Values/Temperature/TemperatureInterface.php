<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Temperature;

interface TemperatureInterface
{

    /**
     * @return int
     */
    public function getValue(): int;
}
