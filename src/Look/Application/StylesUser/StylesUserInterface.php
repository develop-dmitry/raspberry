<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser;

use Raspberry\Core\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleResponse;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleResponse;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;

interface StylesUserInterface
{

    /**
     * @param ToggleStyleRequest $request
     * @return ToggleStyleResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     * @throws FailedSaveUserException
     */
    public function toggleStyle(ToggleStyleRequest $request): ToggleStyleResponse;

    /**
     * @param HasStyleRequest $request
     * @return HasStyleResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     * @throws FailedSaveUserException
     */
    public function hasStyle(HasStyleRequest $request): HasStyleResponse;
}
