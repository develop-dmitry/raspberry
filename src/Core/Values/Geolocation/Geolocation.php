<?php

namespace Raspberry\Core\Values\Geolocation;

use Raspberry\Core\Exceptions\InvalidValueException;

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
     * @param string $decimal
     * @return self
     * @throws InvalidValueException
     */
    public static function fromDecimal(string $decimal): self
    {
        $regex = "/^(\d{1,2}\.\d*),\s(\d{1,3}\.\d*)$/";

        if (!preg_match($regex, $decimal, $matches)) {
            throw new InvalidValueException();
        }

        return new self($matches[1], $matches[2]);
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
     * @inheritDoc
     */
    public function getDecimal(): string
    {
        return "$this->lat, $this->lon";
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
