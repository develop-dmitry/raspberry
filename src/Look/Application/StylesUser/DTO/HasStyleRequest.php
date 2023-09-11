<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class HasStyleRequest extends DataTransferObject
{

    public int $userId;

    public int $styleId;
}
