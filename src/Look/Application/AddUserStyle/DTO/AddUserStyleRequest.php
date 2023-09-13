<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\AddUserStyle\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class AddUserStyleRequest extends DataTransferObject
{

    public int $userId;

    public int $styleId;
}
