<?php

declare(strict_types=1);

namespace Tests\Unit\Wardrobe\Infrastructure\Repositories;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
}
