<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuthorization;

use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationRequest;
use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationResponse;
use Raspberry\Authorization\Domain\User\Exceptions\UserNotFoundException;

interface MessengerAuthorizationInterface
{

    /**
     * @param MessengerAuthorizationRequest $request
     * @return MessengerAuthorizationResponse
     * @throws UserNotFoundException
     */
    public function execute(MessengerAuthorizationRequest $request): MessengerAuthorizationResponse;
}
