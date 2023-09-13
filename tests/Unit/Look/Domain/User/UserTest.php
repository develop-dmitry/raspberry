<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Domain\User;

use Illuminate\Support\Str;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Look\Domain\Style\Style;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testAddStyleToEmptyArray(): void
    {
        $user = new User(new Id(1), []);

        $user->addStyle($this->makeStyle(1));

        $this->assertCount(1, $user->getStyles());
    }

    public function testAddStyleToNotEmptyArray(): void
    {
        $user = new User(new Id(1), [$this->makeStyle(1)]);

        $user->addStyle($this->makeStyle(2));

        $this->assertCount(2, $user->getStyles());
    }

    public function testAddExistStyle(): void
    {
        $style = $this->makeStyle(1);
        $user = new User(new Id(1), [$style]);

        $user->addStyle($style);

        $this->assertCount(1, $user->getStyles());
    }

    public function testRemoveStyle(): void
    {
        $style = $this->makeStyle(1);
        $user = new User(new Id(1), [$style]);

        $user->removeStyle($style);

        $this->assertEmpty($user->getStyles());
    }

    public function testRemoveNonExistentStyle(): void
    {
        $user = new User(new Id(1), [$this->makeStyle(1)]);

        $user->removeStyle($this->makeStyle(2));

        $this->assertCount(1, $user->getStyles());
    }

    protected function makeStyle(int $id): StyleInterface
    {
        return new Style(new Id($id), new Name(Str::random(10)));
    }
}
