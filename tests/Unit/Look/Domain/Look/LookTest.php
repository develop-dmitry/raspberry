<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Domain\Look;

use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Clothes\Clothes;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Look\Look;
use Raspberry\Look\Domain\Style\Style;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\User;
use Raspberry\Look\Domain\User\UserInterface;
use Tests\TestCase;

class LookTest extends TestCase
{

    public function testGetStyles(): void
    {
        $styleFirst = $this->makeStyle(1);
        $styleSecond = $this->makeStyle(2);
        $styleThird = $this->makeStyle(3);

        $clothesFirst = $this->makeClothes(1, [$styleFirst, $styleSecond]);
        $clothesSecond = $this->makeClothes(2, [$styleFirst, $styleSecond, $styleThird]);

        $look = $this->makeLook([$clothesFirst, $clothesSecond]);

        $lookStyles = array_map(static fn (StyleInterface $style) => $style->getId()->getValue(), $look->getStyles());

        $this->assertCount(3, $lookStyles);
        $this->assertContains(1, $lookStyles);
        $this->assertContains(2, $lookStyles);
        $this->assertContains(3, $lookStyles);
    }

    public function testHowFitForEmptyStyles(): void
    {
        $styleFirst = $this->makeStyle(1);
        $styleSecond = $this->makeStyle(2);
        $user = $this->makeUser([$styleFirst, $styleSecond]);
        $look = $this->makeLook([]);

        $this->assertEquals(100, $look->pickerScore($user)->getValue());
    }

    public function testHowFitForEmptyUserStyles(): void
    {
        $styleFirst = $this->makeStyle(1);
        $styleSecond = $this->makeStyle(2);
        $clothesFirst = $this->makeClothes(1, [$styleFirst, $styleSecond]);
        $clothesSecond = $this->makeClothes(2, [$styleFirst]);
        $user = $this->makeUser([]);
        $look = $this->makeLook([$clothesFirst, $clothesSecond]);

        $this->assertEquals(100, $look->pickerScore($user)->getValue());
    }

    public function testHowFit(): void
    {
        $styleFirst = $this->makeStyle(1);
        $styleSecond = $this->makeStyle(2);
        $clothesFirst = $this->makeClothes(1, [$styleFirst, $styleSecond]);
        $clothesSecond = $this->makeClothes(2, [$styleFirst]);
        $user = $this->makeUser([$styleFirst]);
        $look = $this->makeLook([$clothesFirst, $clothesSecond]);

        $this->assertEquals(50, $look->pickerScore($user)->getValue());
    }

    protected function makeUser(array $styles): UserInterface
    {
        return new User(new Id(1), $styles);
    }

    protected function makeLook(array $clothes): Look
    {
        return new Look(
            new Id(1),
            new Name('test'),
            new Slug('test'),
            new Photo('/test.png'),
            $clothes,
            new Temperature(-10),
            new Temperature(10),
            []
        );
    }

    protected function makeClothes(int $id, array $styles): ClothesInterface
    {
        return new Clothes(new Id($id), new Photo('/test.png'), new Name('test'), $styles);
    }

    protected function makeStyle(int $id): StyleInterface
    {
        return new Style(new Id($id), new Name('test'));
    }
}
