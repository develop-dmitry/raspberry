<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\UserStyles\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UserStylesRequest extends DataTransferObject
{

    public int $userId;
}
