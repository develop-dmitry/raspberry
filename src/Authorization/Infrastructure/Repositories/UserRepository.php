<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Infrastructure\Repositories;

use App\Models\User as UserModel;
use Raspberry\Authorization\Domain\User\User;
use Raspberry\Authorization\Domain\User\UserInterface;
use Raspberry\Authorization\Domain\User\UserRepositoryInterface;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Token\Token;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getUserByTelegram(int $telegramId): UserInterface
    {
        $user = UserModel::where('telegram_id', $telegramId)->first();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $this->makeUser($user);
    }

    /**
     * @inheritDoc
     */
    public function createUser(UserInterface $user): UserInterface
    {
        $userModel = UserModel::create([
            'telegram_id' => $user->getTelegramId()?->getValue(),
            'api_token' => $user->getApiToken()->getValue()
        ]);

        if (!$userModel->exists()) {
            throw new FailedSaveUserException();
        }

        return $this->makeUser($userModel);
    }

    /**
     * @param UserModel $user
     * @return UserInterface
     * @throws InvalidValueException
     */
    protected function makeUser(UserModel $user): UserInterface
    {
        return User::make(
            new Id($user->id),
            ($user->telegram_id) ? new Id($user->telegram_id) : null,
            new Token($user->api_token)
        );
    }
}
