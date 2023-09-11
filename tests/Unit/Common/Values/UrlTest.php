<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Url\Url;
use Tests\TestCase;

class UrlTest extends TestCase
{

    public function testValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Url('https://raspberry.ru/look/1');
    }

    public function testInvalidValue(): void
    {
        $this->expectException(InvalidValueException::class);
        new Url('test');
    }
}
