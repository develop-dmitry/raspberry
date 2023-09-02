<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Repositories;

use Raspberry\Common\Base\AbstractRedisRepository;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\Geolocation;
use Raspberry\Common\Values\Geolocation\GeolocationInterface;
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
        return new User(
            $messengerId,
            $values['message_handler'] ?? '',
            $this->makeGeolocation($values['geolocation'] ?? '')
        );
    }

    /**
     * @param string|null $value
     * @return GeolocationInterface|null
     */
    protected function makeGeolocation(?string $value): ?GeolocationInterface
    {
        if (!$value) {
            return null;
        }

        try {
            return Geolocation::fromDecimal($value);
        } catch (InvalidValueException) {
            return null;
        }
    }

    /**
     * @param UserInterface $user
     * @return array
     */
    protected function userToArray(UserInterface $user): array
    {
        return [
            'messenger_id' => $user->getMessengerId(),
            'message_handler' => $user->getMessageHandler(),
            'geolocation' => $user->getGeolocation()?->getDecimal()
        ];
    }
}
