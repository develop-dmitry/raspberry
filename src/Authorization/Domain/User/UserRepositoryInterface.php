<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;

interface UserRepositoryInterface
{
    /**
     * @param int $telegramId
     * @return UserInterface
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function getUserByTelegram(int $telegramId): UserInterface;

    /**
     * @param UserInterface $user
     * @return UserInterface
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    public function createUser(UserInterface $user): UserInterface;
}
