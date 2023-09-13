<?php

namespace Raspberry\Weather\Domain\Weather;

use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Temperature\TemperatureInterface;
use Raspberry\Weather\Domain\Weather\WeatherInterface;

class Weather implements WeatherInterface
{

    /**
     * @param TemperatureInterface $temperature
     * @param GeolocationInterface $geolocation
     */
    public function __construct(
        protected TemperatureInterface $temperature,
        protected GeolocationInterface $geolocation
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getTemperature(): TemperatureInterface
    {
        return $this->temperature;
    }

    /**
     * @inheritDoc
     */
    public function getGeolocation(): GeolocationInterface
    {
        return $this->geolocation;
    }
}
