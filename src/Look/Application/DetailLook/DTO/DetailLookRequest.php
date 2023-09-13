<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class DetailLookRequest extends DataTransferObject
{

    public int $id;
}
