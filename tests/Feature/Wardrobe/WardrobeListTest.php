<?php

declare(strict_types=1);

namespace Tests\Feature\Wardrobe;

use App\Models\Clothes;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class WardrobeListTest extends TestCase
{
    use DatabaseTransactions;

    protected string $uri = '/api/v1/wardrobe/';

    public function testWardrobeForExistentUser(): void
    {
        $clothes = Clothes::factory(10)->create();
        $user = User::factory(1)->create()->first();
        $user->clothes()->sync($clothes);

        $response = $this->post($this->uri, ['api_token' => $user->api_token]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
    }

    public function testWardrobeForNonExistentUser(): void
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->post($this->uri, ['api_token' => '']);

        $response->assertStatus(401);
    }

    public function testWardrobeForEmpty(): void
    {
        $clothes = Clothes::factory(10)->create();
        $user = User::factory(1)->create()->first();
        $user->clothes()->sync($clothes);

        $response = $this->post($this->uri, ['api_token' => $user->api_token]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('items'));
    }
}
