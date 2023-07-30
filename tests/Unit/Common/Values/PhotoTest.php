<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Photo\Photo;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    public function testValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Photo('/storage/jeans.jpg');
    }

    public function testValueWhichEmpty(): void
    {
        $this->expectException(InvalidValueException::class);
        new Photo('');
    }
}
