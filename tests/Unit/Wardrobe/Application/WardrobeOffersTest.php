<?php

declare(strict_types=1);

namespace Tests\Unit\Wardrobe\Application;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\WardrobeOffersUseCase;
use Tests\TestCase;

class WardrobeOffersTest extends TestCase
{
    use DatabaseTransactions;

    public function testExecuteForException(): void
    {
        $user = User::factory(1)->create()->first();

        $wardrobeOffers = app()->make(WardrobeOffersUseCase::class);
        $request = new WardrobeOffersRequest($user->id, 1, 10);

        $this->expectNotToPerformAssertions();
        $wardrobeOffers->execute($request);
    }

    public function testExecuteForOffersCount(): void
    {
        $user = User::factory(1)->create()->first();

        $wardrobeOffers = app()->make(WardrobeOffersUseCase::class);
        $request = new WardrobeOffersRequest($user->id, 1, 10);

        $response = $wardrobeOffers->execute($request);

        $this->assertNotEmpty($response->getOffers());
    }
}
