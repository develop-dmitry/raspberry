<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuth;

use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthRequest;
use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthResponse;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface MessengerAuthInterface
{

    /**
     * @param MessengerAuthRequest $request
     * @return MessengerAuthResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws UnknownProperties
     */
    public function execute(MessengerAuthRequest $request): MessengerAuthResponse;
}
