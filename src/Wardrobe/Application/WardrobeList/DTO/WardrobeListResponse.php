<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class WardrobeListResponse extends DataTransferObject
{

    /**
     * @var ClothesData[]
     */
    public array $items;
}
