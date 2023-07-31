<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeList\DTO;

class WardrobeListResponse
{
    /**
     * @param WardrobeItem[] $items
     */
    public function __construct(
        protected array $items
    ) {
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
