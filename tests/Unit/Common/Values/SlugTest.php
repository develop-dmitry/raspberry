<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Slug\Slug;
use Tests\TestCase;

class SlugTest extends TestCase
{
    public function testValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        new Slug('jeans');
    }

    public function testValueWhichEmpty(): void
    {
        $this->expectException(InvalidValueException::class);
        new Slug('');
    }
}
