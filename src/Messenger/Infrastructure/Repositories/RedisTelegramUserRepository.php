<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Repositories;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Messenger\Domain\Base\Context\User\User;
use Raspberry\Messenger\Domain\Base\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Base\Context\User\UserRepositoryInterface;
use RedisException;
use Predis\Client;

class RedisTelegramUserRepository implements UserRepositoryInterface
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
            $properties = [];

            foreach ($keys as $key) {
                $properties[$this->getPropertyName($key)] = $this->redis->get($key);
            }

            return $this->makeUser($messengerId, $properties);
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
            $properties = $this->userToArray($user);

            foreach ($properties as $key => $value) {
                $this->redis->set($this->pattern($user->getMessengerId(), $key), $value);
            }
        } catch (RedisException $exception) {
            throw new RepositoryException($exception->getMessage());
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
    protected function getPropertyName(string $pattern): string
    {
        $clearPattern = Str::replace($this->prefix, '', $pattern);
        $parts = explode(':', $clearPattern);

        return $parts[2] ?? '';
    }

    /**
     * @param int $messengerId
     * @param array $properties
     * @return UserInterface
     */
    protected function makeUser(int $messengerId, array $properties): UserInterface
    {
        $messageHandler = $properties['message_handler'] ?? '';

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
