<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser;

use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleResponse;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface StylesUserInterface
{

    /**
     * @param ToggleStyleRequest $request
     * @return void
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     * @throws FailedSaveUserException
     * @throws UnknownProperties
     */
    public function toggleStyle(ToggleStyleRequest $request): void;

    /**
     * @param HasStyleRequest $request
     * @return HasStyleResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     * @throws FailedSaveUserException
     * @throws UnknownProperties
     */
    public function hasStyle(HasStyleRequest $request): HasStyleResponse;
}
