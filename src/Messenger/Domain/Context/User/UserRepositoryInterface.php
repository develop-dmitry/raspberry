<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\User;

use Raspberry\Common\Exceptions\RepositoryException;

interface UserRepositoryInterface
{

    /**
     * @param int $messengerId
     * @return UserInterface
     * @throws RepositoryException
     */
    public function getUserByMessengerId(int $messengerId): UserInterface;

    /**
     * @param UserInterface $user
     * @return void
     * @throws RepositoryException
     */
    public function saveUser(UserInterface $user): void;
}
