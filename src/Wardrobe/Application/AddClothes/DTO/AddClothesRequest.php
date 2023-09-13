<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\AddClothes\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class AddClothesRequest extends DataTransferObject
{

    public int $userId;

    public int $clothesId;
}
