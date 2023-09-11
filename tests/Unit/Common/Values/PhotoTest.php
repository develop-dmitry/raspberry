<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Photo\Photo;
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
