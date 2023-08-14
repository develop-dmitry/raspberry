<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Infrastructure\Repositories;

use App\Models\User as UserModel;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Domain\User\Exceptions\UserNotFoundException;
use Raspberry\Authorization\Domain\User\User;
use Raspberry\Authorization\Domain\User\UserInterface;
use Raspberry\Authorization\Domain\User\UserRepositoryInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getUserByTelegram(int $telegramId): UserInterface
    {
        $user = UserModel::where('telegram_id', $telegramId)->first();

        if (!$user) {
            throw new UserNotFoundException();
        }

        try {
            return $this->makeUser($user);
        } catch (InvalidValueException $exception) {
            $this->logger->error('Invalid data in database', ['exception' => $exception->getMessage()]);

            throw new UserNotFoundException($exception->getMessage());
        }
    }

    /**
     * @param UserModel $user
     * @return UserInterface
     * @throws InvalidValueException
     */
    protected function makeUser(UserModel $user): UserInterface
    {
        return new User(
            new Id($user->id),
            ($user->telegram_id) ? new Id($user->telegram_id) : null
        );
    }
}
