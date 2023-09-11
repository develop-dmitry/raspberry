<?php

namespace Raspberry\Weather\Infrastructure\Gateway;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Values\Geolocation\Geolocation;
use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Weather\Domain\Weather\Exceptions\WeatherGatewayException;
use Raspberry\Weather\Domain\Weather\Weather;
use Raspberry\Weather\Domain\Weather\WeatherGatewayInterface;
use Raspberry\Weather\Domain\Weather\WeatherInterface;

class YandexWeatherGateway implements WeatherGatewayInterface
{

    protected string $url = 'https://api.weather.yandex.ru/v2/informers';

    /**
     * @param LoggerInterface $logger
     * @param string $token
     */
    public function __construct(
        protected LoggerInterface $logger,
        protected string $token
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getWeather(float $lat, float $lon): WeatherInterface
    {
        $geolocation = new Geolocation($lat, $lon);

        [$temperature, $minTemperature, $maxTemperature] = $this->parseResponse($this->executeRequest($geolocation));

        return new Weather(
            new Temperature($temperature),
            new Temperature($minTemperature),
            new Temperature($maxTemperature),
            $geolocation
        );
    }

    /**
     * @param GeolocationInterface $geolocation
     * @return array
     * @throws WeatherGatewayException
     */
    protected function executeRequest(GeolocationInterface $geolocation): array
    {
        $query = ['lat' => $geolocation->getLat(), 'lon' => $geolocation->getLon()];
        $response = Http::withHeader('X-Yandex-API-Key', $this->token)->get($this->url, $query);

        if ($response->status() !== 200) {
            $this->logger->emergency('Yandex weather api error', [
                    'status' => $response->status(),
                    'body' => $response->body()]
            );

            throw new WeatherGatewayException();
        }

        return Json::decode($response->body());
    }

    /**
     * @param array $response
     * @return array
     * @throws WeatherGatewayException
     */
    protected function parseResponse(array $response): array
    {
        if (empty($response['forecast']['parts'])) {
            throw new WeatherGatewayException();
        }

        $part = $response['forecast']['parts'][0];

        return [$part['temp_avg'], $part['temp_min'], $part['temp_max']];
    }
}
