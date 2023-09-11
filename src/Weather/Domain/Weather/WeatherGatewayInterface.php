<?php

namespace Raspberry\Weather\Domain\Weather;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;

interface WeatherGatewayInterface
{

    /**
     * @param float $lat
     * @param float $lon
     * @return WeatherInterface
     * @throws InvalidValueException
     * @throws WeatherGatewayException
     */
    public function getWeather(float $lat, float $lon): WeatherInterface;
}
