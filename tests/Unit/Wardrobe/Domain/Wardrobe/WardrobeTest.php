<?php

declare(strict_types=1);

namespace Tests\Unit\Wardrobe\Domain\Wardrobe;

use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Photo\Photo;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Wardrobe\Domain\Clothes\Clothes;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\ClothesAlreadyExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Wardrobe;
use Tests\TestCase;

class WardrobeTest extends TestCase
{
    public function testAddClothes(): void
    {
        $wardrobe = new Wardrobe(new Id(1), []);
        $jeans = new Clothes(
            new Id(1),
            new Name('Jeans'),
            new Slug('jeans'),
            new Photo('/storage/jeans.png')
        );

        $wardrobe->addClothes($jeans);

        $this->assertCount(1, $wardrobe->getClothes());
    }

    public function testReAddClothesForEmptyWardrobe(): void
    {
        $wardrobe = new Wardrobe(new Id(1), []);
        $jeans = new Clothes(
            new Id(1),
            new Name('Jeans'),
            new Slug('jeans'),
            new Photo('/storage/jeans.png')
        );

        $wardrobe->addClothes($jeans);

        $this->expectException(ClothesAlreadyExistsException::class);
        $wardrobe->addClothes($jeans);
    }

    public function testReAddClothesForNotEmptyWardrobe(): void
    {
        $jeans = new Clothes(
            new Id(1),
            new Name('Jeans'),
            new Slug('jeans'),
            new Photo('/storage/jeans.png')
        );
        $wardrobe = new Wardrobe(new Id(1), [$jeans]);

        $this->expectException(ClothesAlreadyExistsException::class);
        $wardrobe->addClothes($jeans);
    }

    public function testRemoveClothes(): void
    {
        $jeans = new Clothes(
            new Id(1),
            new Name('Jeans'),
            new Slug('jeans'),
            new Photo('/storage/jeans.png')
        );
        $shirt = new Clothes(
            new Id(2),
            new Name('Shirt'),
            new Slug('shirt'),
            new Photo('/storage/shirt.png')
        );

        $wardrobe = new Wardrobe(new Id(1), []);
        $wardrobe->addClothes($jeans);
        $wardrobe->addClothes($shirt);

        $wardrobe->removeClothes($jeans);

        $this->assertCount(1, $wardrobe->getClothes());
    }
}
