<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class WardrobeListRequest extends DataTransferObject
{

    public int $userId;
}
