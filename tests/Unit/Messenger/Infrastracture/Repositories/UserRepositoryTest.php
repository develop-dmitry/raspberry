<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Infrastracture\Repositories;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Redis;
use Raspberry\Messenger\Domain\Context\User\User;
use Raspberry\Messenger\Infrastructure\Repositories\TelegramUserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testSaveUser(): void
    {
        $user = new User(1, 'test', null);
        $userRepository = $this->app->make(TelegramUserRepository::class);

        $this->expectNotToPerformAssertions();
        $userRepository->saveUser($user);
    }

    public function testGetUser(): void
    {
        $userRepository = $this->app->make(TelegramUserRepository::class);

        Redis::client()->set('telegram:1:messenger_id', 1);
        Redis::client()->set('telegram:1:message_handler', 'test');

        $user = $userRepository->getUserByMessengerId(1);

        $this->assertEquals(1, $user->getMessengerId());
        $this->assertEquals('test', $user->getMessageHandler());
    }
}
