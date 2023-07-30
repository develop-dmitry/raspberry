<?php

declare(strict_types=1);

namespace Tests\Feature\Wardrobe;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class WardrobeOffersTest extends TestCase
{
    protected string $uri = '/api/v1/wardrobe/{user_id}/offers';

    public function testOffersForExistentUser(): void
    {
        $user = User::factory(1)->create()->first();
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri, ['page' => 1, 'count' => 10]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
    }

    public function testOffersForNonExistentUser(): void
    {
        $user = User::all()->last();
        $uri = Str::replace('{user_id}', $user->id + 100, $this->uri);

        $response = $this->post($uri, ['page' => 1, 'count' => 10]);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
    }

    public function testOffersCount(): void
    {
        $user = User::factory(1)->create()->first();
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri, ['page' => 1, 'count' => 10]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('offers'));
    }
}
