<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use App\Models\Style as StyleModel;
use App\Models\User as UserModel;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Look\Domain\Style\Style;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\UserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{

    public function testGetById(): void
    {
        $model = UserModel::factory(1)->create()->first();
        $userRepository = new UserRepository($this->app->make(StyleRepositoryInterface::class));

        $this->expectNotToPerformAssertions();
        $userRepository->getById($model->id);
    }

    public function testSave(): void
    {
        $styles = StyleModel::factory(3)
            ->create()
            ->map(fn (StyleModel $style) => new Style(new Id($style->id), new Name($style->name)));
        $model = UserModel::factory(1)->create()->first();
        $userRepository = new UserRepository($this->app->make(StyleRepositoryInterface::class));
        $user = $userRepository->getById($model->id);

        foreach ($styles as $style) {
            $user->addStyle($style);
        }

        $userRepository->save($user);

        $this->assertCount(count($styles), UserModel::find($model->id)->styles);
    }
}
