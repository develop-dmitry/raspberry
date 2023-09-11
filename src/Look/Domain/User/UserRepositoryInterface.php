<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\User;

use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;

interface UserRepositoryInterface
{

    /**
     * @param int $id
     * @return UserInterface
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function getById(int $id): UserInterface;

    /**
     * @param UserInterface $user
     * @return void
     * @throws FailedSaveUserException
     * @throws UserNotFoundException
     */
    public function save(UserInterface $user): void;
}
