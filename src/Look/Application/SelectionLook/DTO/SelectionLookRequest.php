<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class SelectionLookRequest extends DataTransferObject
{

    public int $userId;
}
