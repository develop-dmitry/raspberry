<?php

namespace Raspberry\Weather\Application\ActualWeather\DTO;

class ActualWeatherResponse
{

    /**
     * @param int $temperature
     * @param int $minTemperature
     * @param int $maxTemperature
     */
    public function __construct(
        protected int $temperature,
        protected int $minTemperature,
        protected int $maxTemperature
    ) {
    }

    /**
     * @return int
     */
    public function getTemperature(): int
    {
        return $this->temperature;
    }

    /**
     * @return int
     */
    public function getMinTemperature(): int
    {
        return $this->minTemperature;
    }

    /**
     * @return int
     */
    public function getMaxTemperature(): int
    {
        return $this->maxTemperature;
    }
}
