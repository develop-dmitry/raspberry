<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Application\UserStyles;

use App\Models\Style as StyleModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\StylesUser\StylesUserUseCase;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Tests\TestCase;

class UserStylesTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddStyleWhileToggle(): void
    {
        $user = UserModel::factory(1)->create()->first();
        $style = StyleModel::factory(1)->create()->first();
        $userStyles = new StylesUserUseCase(
            $this->app->make(StyleRepositoryInterface::class),
            $this->app->make(UserRepositoryInterface::class)
        );

        $userStyles->toggleStyle(new ToggleStyleRequest(
            userId: $user->id,
            styleId: $style->id
        ));

        $this->assertContains($style->id, $user->styles()->pluck('id'));
    }

    public function testRemoveStyleWhileToggle(): void
    {
        $user = UserModel::factory(1)->create()->first();
        $style = StyleModel::factory(1)->create()->first();
        $user->styles()->attach($style);
        $userStyles = new StylesUserUseCase(
            $this->app->make(StyleRepositoryInterface::class),
            $this->app->make(UserRepositoryInterface::class)
        );

        $request = new ToggleStyleRequest(userId: $user->id, styleId: $style->id);

        $userStyles->toggleStyle($request);

        $this->assertNotContains($style->id, $user->styles()->pluck('id'));
    }
}
