<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Application;

use App\Models\Style as StyleModel;
use App\Models\User as UserModel;
use Raspberry\Look\Application\RemoveUserStyle\DTO\RemoveUserStyleRequest;
use Raspberry\Look\Application\RemoveUserStyle\RemoveUserStyleUseCase;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Tests\TestCase;

class RemoveUserStyleTest extends TestCase
{

    public function testRemoveUserStyle(): void
    {
        $userModel = UserModel::factory(1)->create()->first();
        $styleModel = StyleModel::factory(1)->create()->first();

        $userModel->styles()->attach($styleModel);

        $removeUserStyle = new RemoveUserStyleUseCase(
            app(UserRepositoryInterface::class),
            app(StyleRepositoryInterface::class)
        );
        $request = new RemoveUserStyleRequest(userId: $userModel->id, styleId: $styleModel->id);

        $removeUserStyle->execute($request);

        $this->assertNotContains($styleModel->id, $userModel->styles()->pluck('id'));
    }
}
