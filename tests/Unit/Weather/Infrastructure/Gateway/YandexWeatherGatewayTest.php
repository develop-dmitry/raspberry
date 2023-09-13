<?php

namespace Tests\Unit\Weather\Infrastructure\Gateway;

use Psr\Log\LoggerInterface;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Weather\Infrastructure\Gateway\YandexWeatherGateway;
use Tests\TestCase;

class YandexWeatherGatewayTest extends TestCase
{

    public function testGetWeather(): void
    {
        $yandexWeather = new YandexWeatherGateway(
            app(LoggerInterface::class),
            config('weather.yandex_weather_token')
        );

        $this->expectNotToPerformAssertions();
        $yandexWeather->getWeather(54, 37);
    }

    public function testGetWeatherWithInvalidGeolocation(): void
    {
        $yandexWeather = new YandexWeatherGateway(
            app(LoggerInterface::class),
            config('weather.yandex_weather_token')
        );

        $this->expectException(InvalidValueException::class);
        $yandexWeather->getWeather(-1, 37);
    }
}
