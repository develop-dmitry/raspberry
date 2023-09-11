<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class SelectionLookResponse extends DataTransferObject
{

    /**
     * @var LookData[]
     */
    public array $looks;
}
