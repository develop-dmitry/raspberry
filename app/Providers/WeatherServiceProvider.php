<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Weather\Application\ActualWeather\ActualWeatherInterface;
use Raspberry\Weather\Application\ActualWeather\ActualWeatherUseCase;
use Raspberry\Weather\Domain\Weather\WeatherGatewayInterface;
use Raspberry\Weather\Infrastructure\Gateway\YandexWeatherGateway;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherGatewayInterface::class, YandexWeatherGateway::class);
        $this->app->when(YandexWeatherGateway::class)
            ->needs('$token')
            ->give(config('weather.yandex_weather_token'));
        $this->app->bind(ActualWeatherInterface::class, ActualWeatherUseCase::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
