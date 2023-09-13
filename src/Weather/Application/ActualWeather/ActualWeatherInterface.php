<?php

namespace Raspberry\Weather\Application\ActualWeather;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherRequest;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherResponse;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface ActualWeatherInterface
{

    /**
     * @param ActualWeatherRequest $request
     * @return ActualWeatherResponse
     * @throws InvalidValueException
     * @throws WeatherGatewayException
     * @throws UnknownProperties
     */
    public function execute(ActualWeatherRequest $request): ActualWeatherResponse;
}
