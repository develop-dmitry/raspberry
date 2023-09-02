<?php

namespace Tests\Unit\Common\Values;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\Geolocation;
use Tests\TestCase;

class GeolocationTest extends TestCase
{

    public function testValidValues(): void
    {
        $this->expectNotToPerformAssertions();
        new Geolocation(53, 69);
        new Geolocation(0, 69);
        new Geolocation(53, 180);
    }

    public function testInvalidLatInLowerRange(): void
    {
        $this->expectException(InvalidValueException::class);
        new Geolocation(-1, 69);
    }

    public function testInvalidLatInUpperRange(): void
    {
        $this->expectException(InvalidValueException::class);
        new Geolocation(91, 69);
    }

    public function testInvalidLonInLowerRange(): void
    {
        $this->expectException(InvalidValueException::class);
        new Geolocation(53, -1);
    }

    public function testInvalidLonInUpperRange(): void
    {
        $this->expectException(InvalidValueException::class);
        new Geolocation(53, 181);
    }
}
