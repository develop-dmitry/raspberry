<?php

declare(strict_types=1);

namespace Tests\Unit\Wardrobe\Infrastructure\Repositories;

use App\Models\Clothes as ClothesModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Photo\Photo;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Wardrobe\Domain\Clothes\Clothes;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Infrastructure\Repositories\WardrobeRepository;
use Tests\TestCase;

class WardrobeRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected User $userWithClothes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userWithClothes = User::whereHas('clothes')->first();
    }

    public function testValidWardrobe(): void
    {
        if (!$this->userWithClothes) {
            $this->markTestSkipped('Users with clothes not found');
        }

        $wardrobeRepository = app()->make(WardrobeRepository::class);

        $this->expectNotToPerformAssertions();
        $wardrobeRepository->getWardrobe($this->userWithClothes->id);
    }

    public function testClothesCount(): void
    {
        if (!$this->userWithClothes) {
            $this->markTestSkipped('Users with clothes not found');
        }

        $wardrobeRepository = app()->make(WardrobeRepository::class);
        $wardrobe = $wardrobeRepository->getWardrobe($this->userWithClothes->id);

        $this->assertCount($this->userWithClothes->clothes->count(), $wardrobe->getClothes());
    }

    public function testClothesData(): void
    {
        $user = User::factory(1)->create()->first();
        $clothesModel = ClothesModel::factory(1)->create()->first();

        $user->clothes()->sync($clothesModel);

        $wardrobeRepository = app()->make(WardrobeRepository::class);
        $wardrobe = $wardrobeRepository->getWardrobe($user->id);

        $clothes = $wardrobe->getClothes();

        $this->assertCount(1, $clothes);
        $this->assertEquals($clothesModel->id, $clothes[0]->getId()->getValue());
        $this->assertEquals($clothesModel->name, $clothes[0]->getName()->getValue());
        $this->assertEquals($clothesModel->slug, $clothes[0]->getSlug()->getValue());
        $this->assertEquals($clothesModel->photo, $clothes[0]->getPhoto()->getValue());
    }

    public function testEmptyWardrobe(): void
    {
        $user = User::factory(1)->create()->first();

        $wardrobeRepository = app()->make(WardrobeRepository::class);
        $wardrobe = $wardrobeRepository->getWardrobe($user->id);

        $this->assertEmpty($wardrobe->getClothes());
    }

    public function testWardrobeForNonExistentUser(): void
    {
        $user = User::all()->last();
        $wardrobeRepository = app()->make(WardrobeRepository::class);

        $this->expectException(UserDoesNotExistsException::class);
        $wardrobeRepository->getWardrobe($user->id + 100);
    }

    public function testSaveWardrobe(): void
    {
        $wardrobeRepository = app()->make(WardrobeRepository::class);
        $wardrobe = $wardrobeRepository->getWardrobe($this->userWithClothes->id);

        $clothesModel = ClothesModel::factory(1)->create()->first();

        if (!$clothesModel) {
            $this->markTestSkipped('Failed to create clothes');
        }

        $clothes = new Clothes(
            new Id($clothesModel->id),
            new Name($clothesModel->name),
            new Slug($clothesModel->slug),
            new Photo($clothesModel->photo)
        );
        $wardrobe->addClothes($clothes);
        $wardrobeRepository->saveWardrobe($wardrobe);

        $this->assertCount($this->userWithClothes->clothes()->count(), $wardrobe->getClothes());
    }
}
