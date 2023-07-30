<?php

declare(strict_types=1);

namespace Tests\Unit\Wardrobe\Infrastructure\Repositories;

use App\Models\Clothes;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Infrastructure\Repositories\ClothesRepository;
use Tests\TestCase;

class ClothesRepositoryTest extends TestCase
{
    public function testGetValidClothes(): void
    {
        $clothesModel = Clothes::first();

        if (!$clothesModel) {
            $this->markTestSkipped('Clothes not found');
        }

        $clothesRepository = app()->make(ClothesRepository::class);
        $clothes = $clothesRepository->getClothesById($clothesModel->id);

        $this->assertEquals($clothesModel->id, $clothes->getId()->getValue());
    }

    public function testGetNonExistentClothes(): void
    {
        $clothesModel = Clothes::all()->last();
        $clothesRepository = app()->make(ClothesRepository::class);

        $this->expectException(ClothesNotFoundException::class);
        $clothesRepository->getClothesById($clothesModel->id + 100);
    }
}
