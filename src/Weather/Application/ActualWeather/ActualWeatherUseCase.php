<?php

namespace Raspberry\Weather\Application\ActualWeather;

use Raspberry\Weather\Application\ActualWeather\ActualWeatherInterface;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherRequest;
use Raspberry\Weather\Application\ActualWeather\DTO\ActualWeatherResponse;
use Raspberry\Weather\Domain\Weather\WeatherGatewayInterface;

class ActualWeatherUseCase implements ActualWeatherInterface
{

    /**
     * @param WeatherGatewayInterface $weatherGateway
     */
    public function __construct(
        protected WeatherGatewayInterface $weatherGateway
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(ActualWeatherRequest $request): ActualWeatherResponse
    {
        $weather = $this->weatherGateway->getWeather($request->getLat(), $request->getLon());

        return new ActualWeatherResponse(
            $weather->getTemperature()->getValue(),
            $weather->getMinTemperature()->getValue(),
            $weather->getMaxTemperature()->getValue()
        );
    }
}
