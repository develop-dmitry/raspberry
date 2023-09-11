<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\User;

use Raspberry\Core\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Core\Values\Exceptions\InvalidValueException;

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
