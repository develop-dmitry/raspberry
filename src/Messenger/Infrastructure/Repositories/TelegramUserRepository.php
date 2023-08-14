<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Repositories;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Predis\Client;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Messenger\Domain\Context\User\User;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use RedisException;

class TelegramUserRepository implements UserRepositoryInterface
{

    protected Client $redis;

    protected string $pattern = 'telegram:{id}:{property}';

    protected string $prefix = 'raspberry_database_';

    public function __construct()
    {
        $this->redis = Redis::client();
    }

    /**
     * @inheritDoc
     */
    public function getUserByMessengerId(int $messengerId): UserInterface
    {
        try {
            $keys = $this->keys($this->pattern($messengerId));
            $values = $this->getValues($keys);

            return $this->makeUser($messengerId, $values);
        } catch (RedisException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function saveUser(UserInterface $user): void
    {
        try {
            $values = $this->userToArray($user);
            $this->saveValues($user->getMessengerId(), $values);
        } catch (RedisException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    /**
     * @param array $keys
     * @return array
     * @throws RedisException
     */
    protected function getValues(array $keys): array
    {
        $values = [];

        foreach ($keys as $key) {
            $valueName = $this->getValueName($key);
            $values[$valueName] = $this->redis->get($key);
        }

        return $values;
    }

    /**
     * @throws RedisException
     */
    protected function saveValues(int $id, array $values): void
    {
        foreach ($values as $name => $value) {
            $key = $this->pattern($id, $name);
            $this->redis->set($key, $value);
        }
    }

    /**
     * @param int $id
     * @param string $property
     * @return string
     */
    public function pattern(int $id, string $property = '*'): string
    {
        return Str::replace(['{id}', '{property}'], [$id, $property], $this->pattern);
    }

    /**
     * @param string $pattern
     * @return string[]
     * @throws RedisException
     */
    protected function keys(string $pattern): array
    {
        $keys = $this->redis->keys($pattern);

        return array_map(fn(string $key) => Str::replace($this->prefix, '', $key), $keys);
    }

    /**
     * @param string $pattern
     * @return string
     */
    protected function getValueName(string $pattern): string
    {
        $clearPattern = Str::replace($this->prefix, '', $pattern);
        $parts = explode(':', $clearPattern);

        return $parts[2] ?? '';
    }

    /**
     * @param int $messengerId
     * @param array $values
     * @return UserInterface
     */
    protected function makeUser(int $messengerId, array $values): UserInterface
    {
        $messageHandler = $values['message_handler'] ?? '';

        return new User($messengerId, $messageHandler);
    }

    /**
     * @param UserInterface $user
     * @return array
     */
    protected function userToArray(UserInterface $user): array
    {
        return [
            'messenger_id' => $user->getMessengerId(),
            'message_handler' => $user->getMessageHandler()
        ];
    }
}
