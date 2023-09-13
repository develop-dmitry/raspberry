<?php

namespace Tests\Unit\Common\Values;

use Illuminate\Support\Str;
use Raspberry\Core\Values\Token\Token;
use Tests\TestCase;

class TokenTest extends TestCase
{

    public function testMakeToken(): void
    {
        $this->expectNotToPerformAssertions();
        new Token(Str::random(60));
    }
}
