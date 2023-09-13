<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\RemoveUserStyle;

use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\RemoveUserStyle\DTO\RemoveUserStyleRequest;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;

interface RemoveUserStyleInterface
{

    /**
     * @param RemoveUserStyleRequest $request
     * @return void
     * @throws UserNotFoundException
     * @throws StyleNotFoundException
     * @throws InvalidValueException
     * @throws FailedSaveUserException
     */
    public function execute(RemoveUserStyleRequest $request): void;
}
