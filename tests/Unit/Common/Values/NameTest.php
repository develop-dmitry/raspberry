<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Name\Name;
use Tests\TestCase;

class NameTest extends TestCase
{
    public function testValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Name('Jeans');
    }

    public function testValueWhichEmpty(): void
    {
        $this->expectException(InvalidValueException::class);
        new Name('');
    }
}
