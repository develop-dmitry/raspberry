<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Application;

use App\Models\Style as StyleModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Look\Application\AddUserStyle\AddUserStyleUseCase;
use Raspberry\Look\Application\AddUserStyle\DTO\AddUserStyleRequest;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Tests\TestCase;

class AddUserStyleTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddUserStyle(): void
    {
        $userModel = UserModel::factory(1)->create()->first();
        $styleModel = StyleModel::factory(1)->create()->first();

        $addUserStyle = new AddUserStyleUseCase(
            app(UserRepositoryInterface::class),
            app(StyleRepositoryInterface::class)
        );

        $request = new AddUserStyleRequest(userId: $userModel->id, styleId: $styleModel->id);
        $addUserStyle->execute($request);

        $this->assertContains($styleModel->id, $userModel->styles()->pluck('id'));
    }
}
