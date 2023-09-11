<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerRegister;

use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterRequest;
use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterResponse;
use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface MessengerRegisterInterface
{

    /**
     * @param MessengerRegisterRequest $request
     * @return MessengerRegisterResponse
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     * @throws UnknownProperties
     */
    public function execute(MessengerRegisterRequest $request): MessengerRegisterResponse;
}
