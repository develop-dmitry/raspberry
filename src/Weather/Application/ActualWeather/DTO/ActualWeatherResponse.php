<?php

namespace Raspberry\Weather\Application\ActualWeather\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ActualWeatherResponse extends DataTransferObject
{

    public int $temperature;
}
