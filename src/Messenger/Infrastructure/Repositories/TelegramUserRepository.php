<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Repositories;

use Raspberry\Common\Base\AbstractRedisRepository;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Messenger\Domain\Context\User\User;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use RedisException;

class TelegramUserRepository extends AbstractRedisRepository implements UserRepositoryInterface
{

    protected string $name = 'telegram';

    /**
     * @inheritDoc
     */
    public function getUserByMessengerId(int $messengerId): UserInterface
    {
        try {
            $keys = $this->keys($this->path($messengerId));
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
