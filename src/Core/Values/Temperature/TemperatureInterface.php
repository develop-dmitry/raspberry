<?php

declare(strict_types=1);

namespace Raspberry\Core\Values\Temperature;

interface TemperatureInterface
{

    /**
     * @return int
     */
    public function getValue(): int;

    /**
     * @return string
     */
    public function getCelsius(): string;
}
