<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class WardrobeOffersRequest extends DataTransferObject
{

    public int $userId;

    public int $page;

    public int $count;
}
