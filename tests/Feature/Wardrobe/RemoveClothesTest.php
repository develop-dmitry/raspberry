<?php

declare(strict_types=1);

namespace Tests\Feature\Wardrobe;

use App\Models\Clothes;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class RemoveClothesTest extends TestCase
{
    use DatabaseTransactions;

    protected string $uri = '/api/v1/wardrobe/remove';

    public function testSuccessRemoveClothes(): void
    {
        $user = User::factory(1)->create()->first();
        $clothes = Clothes::factory(1)->create()->first();
        $user->clothes()->sync($clothes);

        $response = $this->post($this->uri, ['clothes_id' => $clothes->id, 'api_token' => $user->api_token]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
    }

    public function testRemoveForNonExistentUser(): void
    {
        $clothes = Clothes::factory(1)->create()->first();

        $response = $this->withHeader('Accept', 'application/json')
            ->post($this->uri, ['clothes_id' => $clothes->id, 'api_token' => '']);

        $response->assertStatus(401);
    }

    public function testRemoveNonExistentClothes(): void
    {
        $user = User::factory(1)->create()->first();
        $clothes = Clothes::all()->last();

        $response = $this->post($this->uri, ['clothes_id' => $clothes->id + 100, 'api_token' => $user->api_token]);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
    }
}
