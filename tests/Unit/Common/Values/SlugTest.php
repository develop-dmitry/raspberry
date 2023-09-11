<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Values;

use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Slug\Slug;
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
