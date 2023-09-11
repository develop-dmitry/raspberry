<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Id\Id;
use Tests\TestCase;

class IdTest extends TestCase
{
    public function testValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Id(1);
    }

    public function testValueWhichLessZero(): void
    {
        $this->expectException(InvalidValueException::class);
        new Id(-1);
    }

    public function testValueWhichEqualsZero(): void
    {
        $this->expectException(InvalidValueException::class);
        new Id(0);
    }
}
