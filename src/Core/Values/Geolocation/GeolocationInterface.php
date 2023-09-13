<?php

namespace Raspberry\Core\Values\Geolocation;

interface GeolocationInterface
{

    /**
     * @return float
     */
    public function getLat(): float;

    /**
     * @return float
     */
    public function getLon(): float;

    /**
     * @return string
     */
    public function getDecimal(): string;
}
