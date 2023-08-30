<?php

namespace Tests\Unit\Common\Values;

use Illuminate\Support\Str;
use Raspberry\Common\Values\Token\Token;
use Tests\TestCase;

class TokenTest extends TestCase
{

    public function testMakeToken(): void
    {
        $this->expectNotToPerformAssertions();
        new Token(Str::random(60));
    }


    public function testGetHashToken(): void
    {
        $value = Str::random(60);
        $token = new Token($value);

        $this->assertEquals(hash('sha256', $value), $token->getHashValue());
    }
}
