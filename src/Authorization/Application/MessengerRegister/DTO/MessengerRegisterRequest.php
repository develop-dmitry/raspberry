<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerRegister\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class MessengerRegisterRequest extends DataTransferObject
{

    public int $messengerId;
}
