<?php

namespace Raspberry\Weather\Application\ActualWeather;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherRequest;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherResponse;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;

interface ActualWeatherInterface
{

    /**
     * @param ActualWeatherRequest $request
     * @return ActualWeatherResponse
     * @throws InvalidValueException
     * @throws WeatherGatewayException
     */
    public function execute(ActualWeatherRequest $request): ActualWeatherResponse;
}
