<?php

namespace Raspberry\Weather\Application\ActualWeather\DTO;

class ActualWeatherRequest
{

    /**
     * @param float $lat
     * @param float $lon
     */
    public function __construct(
        protected float $lat,
        protected float $lon
    ) {
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }
}
