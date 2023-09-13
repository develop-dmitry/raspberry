<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuth\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class MessengerAuthRequest extends DataTransferObject
{

    public int $messengerId;
}
