<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerRegister\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class MessengerRegisterResponse extends DataTransferObject
{

    public int $userId;

    public string $apiToken;
}
