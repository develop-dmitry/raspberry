<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Infrastructure\Repositories;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Authorization\Domain\User\Exceptions\UserNotFoundException;
use Raspberry\Authorization\Infrastructure\Repositories\UserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetUserByTelegramId(): void
    {
        $userModel = User::factory(1)->create()->first();
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
}
