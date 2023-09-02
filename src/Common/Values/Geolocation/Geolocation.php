<?php

namespace Raspberry\Common\Values\Geolocation;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\GeolocationInterface;

class Geolocation implements GeolocationInterface
{

    protected float $lat;

    protected float $lon;

    /**
     * @param float $lat
     * @param float $lon
     * @throws InvalidValueException
     */
    public function __construct(float $lat, float $lon)
    {
        $this->validate($lat, $lon);

        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @inheritDoc
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @inheritDoc
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * @param float $lat
     * @param float $lon
     * @return void
     * @throws InvalidValueException
     */
    protected function validate(float $lat, float $lon): void
    {
        if ($lat < 0 || $lat > 90) {
            throw new InvalidValueException();
        }

        if ($lon < 0 || $lon > 180) {
            throw new InvalidValueException();
        }
    }
}
