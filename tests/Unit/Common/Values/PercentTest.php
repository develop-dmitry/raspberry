<?php

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Enums\CompareResult;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Percent\Percent;
use Tests\TestCase;

class PercentTest extends TestCase
{

    public function testValueLessZero(): void
    {
        $this->expectException(InvalidValueException::class);
        new Percent(-10);
    }

    public function testZeroValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Percent(0);
    }

    public function testValueMoreOneHundred(): void
    {
        $this->expectException(InvalidValueException::class);
        new Percent(110);
    }

    public function testOneHundredValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Percent(100);
    }

    public function testNormalValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Percent(55);
    }

    public function testMax(): void
    {
        $this->expectNotToPerformAssertions();
        Percent::max();
    }

    public function testFromDecimal(): void
    {
        $percent = Percent::fromDecimal(0.1);

        $this->assertEquals(10, $percent->getValue());
    }

    public function testCompareEqual(): void
    {
        $this->assertEquals(CompareResult::Equal, Percent::max()->compare(Percent::max()));
    }

    public function testCompareLess(): void
    {
        $this->assertEquals(CompareResult::Less, Percent::fromDecimal(0.1)->compare(Percent::max()));
    }

    public function testCompareMore(): void
    {
        $this->assertEquals(CompareResult::More, Percent::max()->compare(Percent::fromDecimal(0.1)));
    }
}
