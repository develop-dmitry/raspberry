<?php

declare(strict_types=1);

namespace Tests\Feature\Wardrobe;

use App\Models\Clothes;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddClothesTest extends TestCase
{
    use DatabaseTransactions;

    protected string $uri = '/api/v1/wardrobe/{user_id}/add';

    public function testSuccessAddClothes(): void
    {
        $user = User::factory(1)->create()->first();
        $clothes = Clothes::factory(1)->create()->first();
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri, ['clothes_id' => $clothes->id]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
    }

    public function testDoubleAddClothes(): void
    {
        $user = User::factory(1)->create()->first();
        $clothes = Clothes::factory(1)->create()->first();
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri, ['clothes_id' => $clothes->id]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));

        $response = $this->post($uri, ['clothes_id' => $clothes->id]);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
    }

    public function testAddNonExistentClothes(): void
    {
        $user = User::factory(1)->create()->first();
        $clothes = Clothes::all()->last();
        $uri = Str::replace('{user_id}', $user->id, $this->uri);

        $response = $this->post($uri, ['clothes_id' => $clothes->id + 100]);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
    }

    public function testAddClothesForNonExistentUser(): void
    {
        $user = User::all()->last();
        $clothes = Clothes::all()->last();
        $uri = Str::replace('{user_id}', $user->id + 100, $this->uri);

        $response = $this->post($uri, ['clothes_id' => $clothes->id]);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
    }
}
