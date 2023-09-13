<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuth\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class MessengerAuthResponse extends DataTransferObject
{

    public int $userId;

    public string $apiToken;
}
