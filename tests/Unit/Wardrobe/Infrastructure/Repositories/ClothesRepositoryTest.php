<?php

declare(strict_types=1);

namespace Tests\Unit\Wardrobe\Infrastructure\Repositories;

use App\Models\Clothes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Infrastructure\Repositories\ClothesRepository;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Tests\TestCase;

class ClothesRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetValidClothes(): void
    {
        $clothesModel = Clothes::first();

        if (!$clothesModel) {
            $this->markTestSkipped('Clothes not found');
        }

        $clothesRepository = app()->make(ClothesRepository::class);
        $clothes = $clothesRepository->getById($clothesModel->id);

        $this->assertEquals($clothesModel->id, $clothes->getId()->getValue());
    }

    public function testGetNonExistentClothes(): void
    {
        $clothesModel = Clothes::all()->last();
        $clothesRepository = app()->make(ClothesRepository::class);

        $this->expectException(ClothesNotFoundException::class);
        $clothesRepository->getById($clothesModel->id + 100);
    }

    public function testWhereNotIn(): void
    {
        $exclude = Clothes::factory(3)
            ->create()
            ->map(fn (Clothes $item) => $item->id)
            ->toArray();

        $clothesRepository = new ClothesRepository();
        $clothes = $clothesRepository->whereNotIn($exclude, 1, Clothes::all()->count());
        $clothes = array_map(fn (ClothesInterface $clothes) => $clothes->getId()->getValue(), $clothes->getItems());

        foreach ($exclude as $id) {
            $this->assertNotContains($id, $clothes);
        }
    }
}
