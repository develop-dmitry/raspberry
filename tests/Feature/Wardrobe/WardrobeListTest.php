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

    protected string $uri = '/api/v1/wardrobe/{user_id}';

    public function testWardrobeForExistentUser(): void
    {
        $clothes = Clothes::factory(10)->create();
        $user = User::factory(1)->create()->first();
        $user->clothes()->sync($clothes);
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
    }

    public function testWardrobeForNonExistentUser(): void
    {
        $user = User::all()->last();
        $uri = Str::replace('{user_id}', $user->id + 100, $this->uri);

        $response = $this->post($uri);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
    }

    public function testWardrobeForEmpty(): void
    {
        $clothes = Clothes::factory(10)->create();
        $user = User::factory(1)->create()->first();
        $user->clothes()->sync($clothes);
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('items'));
    }
}
