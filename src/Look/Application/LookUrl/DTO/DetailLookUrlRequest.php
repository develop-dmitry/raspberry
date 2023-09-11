<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\LookUrl\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class DetailLookUrlRequest extends DataTransferObject
{

    public int $lookId;

    public array $query;
}
