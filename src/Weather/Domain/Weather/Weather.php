<?php

namespace Raspberry\Weather\Domain\Weather;

use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Temperature\TemperatureInterface;
use Raspberry\Weather\Domain\Weather\WeatherInterface;

class Weather implements WeatherInterface
{

    /**
     * @param TemperatureInterface $temperature
     * @param TemperatureInterface $minTemperature
     * @param TemperatureInterface $maxTemperature
     * @param GeolocationInterface $geolocation
     */
    public function __construct(
        protected TemperatureInterface $temperature,
        protected TemperatureInterface $minTemperature,
        protected TemperatureInterface $maxTemperature,
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
    public function getMinTemperature(): TemperatureInterface
    {
        return $this->minTemperature;
    }

    /**
     * @inheritDoc
     */
    public function getMaxTemperature(): TemperatureInterface
    {
        return $this->maxTemperature;
    }

    /**
     * @inheritDoc
     */
    public function getGeolocation(): GeolocationInterface
    {
        return $this->geolocation;
    }
}
