<?php

namespace Raspberry\Common\Values\Geolocation;

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
}
