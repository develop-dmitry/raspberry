<?php

namespace Raspberry\Weather\Application\ActualWeather\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ActualWeatherRequest extends DataTransferObject
{

    public float $lat;

    public float $lon;
}
