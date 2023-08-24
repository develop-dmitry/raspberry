<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\UserStyles;

use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\UserStyles\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\UserStyles\DTO\ToggleStyleResponse;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;

interface UserStylesInterface
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
}
