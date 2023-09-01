<?php

namespace Tests\Feature\Look;

use App\Models\Clothes;
use App\Models\Look;
use App\Models\Style;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HowFitTest extends TestCase
{
    use DatabaseTransactions;

    public function testHowFit(): void
    {
        $styles = Style::factory(3)->create();
        $user = User::factory(1)->create()->first();
        $user->styles()->sync($styles);
        $clothes = Clothes::factory(1)->create()->first();
        $clothes->styles()->sync($styles->random(2));
        $look = Look::factory(1)->create()->first();
        $look->clothes()->sync($clothes);

        $response = $this->post($this->getUrl($look->id), ['api_token' => $user->api_token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'how_fit'
        ]);
    }

    public function testHowFitForNonExistentUser(): void
    {
        $styles = Style::factory(3)->create();
        $clothes = Clothes::factory(1)->create()->first();
        $clothes->styles()->sync($styles->random(2));
        $look = Look::factory(1)->create()->first();
        $look->clothes()->sync($clothes);

        $response = $this->withHeader('Accept', 'application/json')
            ->post($this->getUrl($look->id), ['api_token' => '']);

        $response->assertStatus(401);
    }

    public function testHowFitForNonExistentLook(): void
    {
        $styles = Style::factory(3)->create();
        $user = User::factory(1)->create()->first();
        $user->styles()->sync($styles);

        $response = $this->post($this->getUrl(Look::all()->last()->id + 100), ['api_token' => $user->api_token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }

    protected function getUrl(int $lookId): string
    {
        return "/api/v1/look/$lookId/how-fit";
    }
}
