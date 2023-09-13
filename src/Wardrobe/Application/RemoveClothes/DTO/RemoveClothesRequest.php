<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\RemoveClothes\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class RemoveClothesRequest extends DataTransferObject
{

    public int $userId;

    public int $clothesId;
}
