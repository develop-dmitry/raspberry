<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\RemoveUserStyle\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class RemoveUserStyleRequest extends DataTransferObject
{

    public int $userId;

    public int $styleId;
}
