<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Application;

use App\Models\Style;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Look\Application\UserStyles\DTO\UserStylesRequest;
use Raspberry\Look\Application\UserStyles\UserStylesUseCase;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Tests\TestCase;

class UserStylesTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserStyles(): void
    {
        $styles = Style::factory(3)->create();
        $user = User::factory(1)->create()->first();

        $user->styles()->sync($styles);

        $userStyles = new UserStylesUseCase(app(UserRepositoryInterface::class));
        $request = new UserStylesRequest(userId: $user->id);

        $userStyles = $userStyles->execute($request);

        $this->assertCount($styles->count(), array_intersect($userStyles->styles, $styles->pluck('id')->toArray()));
    }
}
