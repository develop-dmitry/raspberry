<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\UserStyles\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UserStylesResponse extends DataTransferObject
{

    /**
     * @var int[]
     */
    public array $styles;
}
