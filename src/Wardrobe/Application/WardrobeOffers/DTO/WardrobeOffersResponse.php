<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class WardrobeOffersResponse extends DataTransferObject
{

    /**
     * @var ClothesData[]
     */
    public array $items;

    public int $page;

    public int $total;

    public int $count;
}
