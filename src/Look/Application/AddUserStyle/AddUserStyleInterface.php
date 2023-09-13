<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\AddUserStyle;

use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\AddUserStyle\DTO\AddUserStyleRequest;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;

interface AddUserStyleInterface
{

    /**
     * @param AddUserStyleRequest $request
     * @return void
     * @throws UserNotFoundException
     * @throws StyleNotFoundException
     * @throws InvalidValueException
     * @throws FailedSaveUserException
     */
    public function execute(AddUserStyleRequest $request): void;
}
