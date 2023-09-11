<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuth;

use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthRequest;
use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthResponse;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;

interface MessengerAuthInterface
{

    /**
     * @param MessengerAuthRequest $request
     * @return MessengerAuthResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function execute(MessengerAuthRequest $request): MessengerAuthResponse;
}
