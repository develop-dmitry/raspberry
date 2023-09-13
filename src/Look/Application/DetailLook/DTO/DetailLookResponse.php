<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class DetailLookResponse extends DataTransferObject
{

    public int $id;

    public string $name;

    public string $slug;

    public string $photo;

    /**
     * @var ClothesData[]
     */
    public array $clothes;

    /**
     * @var EventData[]
     */
    public array $events;
}
