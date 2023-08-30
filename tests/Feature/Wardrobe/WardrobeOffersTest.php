<?php

declare(strict_types=1);

namespace Tests\Feature\Wardrobe;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class WardrobeOffersTest extends TestCase
{
    protected string $uri = '/api/v1/wardrobe/offers';

    public function testOffersForExistentUser(): void
    {
        $user = User::factory(1)->create()->first();

        $response = $this->post($this->uri, ['page' => 1, 'count' => 10, 'api_token' => $user->api_token]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
    }

    public function testOffersForNonExistentUser(): void
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->post($this->uri, ['page' => 1, 'count' => 10, 'api_token' => '']);

        $response->assertStatus(401);
    }

    public function testOffersCount(): void
    {
        $user = User::factory(1)->create()->first();

        $response = $this->post($this->uri, ['page' => 1, 'count' => 10, 'api_token' => $user->api_token]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('offers'));
    }
}
