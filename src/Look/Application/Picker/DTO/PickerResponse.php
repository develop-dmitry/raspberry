<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\Picker\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PickerResponse extends DataTransferObject
{

    /**
     * @var LookData[]
     */
    public array $looks;
}
