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
     * @return TemperatureInterface
     */
    public function getMinTemperature(): TemperatureInterface;

    /**
     * @return TemperatureInterface
     */
    public function getMaxTemperature(): TemperatureInterface;

    /**
     * @return GeolocationInterface
     */
    public function getGeolocation(): GeolocationInterface;
}
