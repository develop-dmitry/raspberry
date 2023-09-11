<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class HasStyleResponse extends DataTransferObject
{

    public bool $hasStyle;
}
