<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\UserStyles;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\UserStyles\DTO\UserStylesRequest;
use Raspberry\Look\Application\UserStyles\DTO\UserStylesResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface UserStylesInterface
{

    /**
     * @param UserStylesRequest $request
     * @return UserStylesResponse
     * @throws UnknownProperties
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function execute(UserStylesRequest $request): UserStylesResponse;
}
