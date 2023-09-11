<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class DetailLookUrlResponse extends DataTransferObject
{

    public string $url;
}
