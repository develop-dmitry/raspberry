<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Temperature\Temperature;
use Tests\TestCase;

class TemperatureTest extends TestCase
{

    public function testValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Temperature(10);
    }

    public function testValueLessMinusFifty(): void
    {
        $this->expectException(InvalidValueException::class);
        new Temperature(-51);
    }

    public function testValueMoreFifty(): void
    {
        $this->expectException(InvalidValueException::class);
        new Temperature(51);
    }

    public function testStringValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Temperature('+10');
    }

    public function testZeroValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Temperature('0');
    }

    public function testCelsiusValue(): void
    {
        $temperature = new Temperature(9);

        $this->assertEquals('+9°C', $temperature->getCelsius());
    }

    public function testMinusCelsiusValue(): void
    {
        $temperature = new Temperature(-9);

        $this->assertEquals('-9°C', $temperature->getCelsius());
    }

    public function testZeroCelsiusValue(): void
    {
        $temperature = new Temperature(0);

        $this->assertEquals('0°C', $temperature->getCelsius());
    }
}
