<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuthorization;

use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationRequest;
use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationResponse;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;

interface MessengerAuthorizationInterface
{

    /**
     * @param MessengerAuthorizationRequest $request
     * @return MessengerAuthorizationResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function execute(MessengerAuthorizationRequest $request): MessengerAuthorizationResponse;
}
