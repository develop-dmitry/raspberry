<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Raspberry\Authorization\Domain\User\Exceptions\UserNotFoundException;

interface UserRepositoryInterface
{
    /**
     * @param int $telegramId
     * @return UserInterface
     * @throws UserNotFoundException
     */
    public function getUserByTelegram(int $telegramId): UserInterface;
}
