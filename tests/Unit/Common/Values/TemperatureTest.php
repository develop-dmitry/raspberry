<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Temperature\Temperature;
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
}
