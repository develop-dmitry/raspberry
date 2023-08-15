<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerRegister;

use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterRequest;
use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterResponse;
use Raspberry\Authorization\Domain\User\Exceptions\FailedSaveUserException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;

interface MessengerRegisterInterface
{

    /**
     * @param MessengerRegisterRequest $request
     * @return MessengerRegisterResponse
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    public function execute(MessengerRegisterRequest $request): MessengerRegisterResponse;
}
