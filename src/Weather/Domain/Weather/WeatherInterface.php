<?php

namespace Raspberry\Weather\Domain\Weather;

use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Temperature\TemperatureInterface;

interface WeatherInterface
{

    /**
     * @return TemperatureInterface
     */
    public function getTemperature(): TemperatureInterface;

    /**
     * @return GeolocationInterface
     */
    public function getGeolocation(): GeolocationInterface;
}
