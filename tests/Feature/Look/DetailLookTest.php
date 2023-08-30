<?php

declare(strict_types=1);

namespace Tests\Feature\Look;

use App\Models\Look;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class DetailLookTest extends TestCase
{
    use DatabaseTransactions;

    protected string $uri = '/api/v1/look/{look_id}';

    public function testDetailForExistsLook(): void
    {
        $user = User::factory(1)->create()->first();
        $look = Look::factory(1)->create()->first();
        $uri = Str::replace('{look_id}', $look->id, $this->uri);

        $response = $this->post($uri, ['api_token' => $user->api_token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'look' => [
                'id',
                'name',
                'slug',
                'photo',
                'clothes' => [
                    '*' => [
                        'id',
                        'photo',
                        'name'
                    ]
                ]
            ],
            'success'
        ]);
    }

    public function testDetailForNonExistsLook(): void
    {
        $user = User::factory(1)->create()->first();
        $look = Look::all()->last();
        $uri = Str::replace('{look_id}', $look->id + 100, $this->uri);

        $response = $this->post($uri, ['api_token' => $user->api_token]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
    }
}
