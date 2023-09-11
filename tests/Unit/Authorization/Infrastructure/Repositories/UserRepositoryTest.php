<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Infrastructure\Repositories;

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Authorization\Domain\User\User;
use Raspberry\Authorization\Infrastructure\Repositories\UserRepository;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Core\Values\Id\Id;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetUserByTelegramId(): void
    {
        $userModel = UserModel::factory(1)->create()->first();
        $userRepository = $this->app->make(UserRepository::class);

        $user = $userRepository->getUserByTelegram($userModel->telegram_id);

        $this->assertEquals($userModel->id, $user->getId()->getValue());
    }

    public function testGetNonExistentUserByTelegramId(): void
    {
        $userRepository = $this->app->make(UserRepository::class);

        $this->expectException(UserNotFoundException::class);
        $userRepository->getUserByTelegram(-1);
    }

    public function testCreateUser(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = User::register(new Id(random_int(1, 100000)));

        $userRepository->createUser($user);

        $this->assertNotNull(UserModel::where('telegram_id', $user->getTelegramId()->getValue())->first());
    }
}
