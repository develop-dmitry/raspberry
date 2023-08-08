<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

class ClothesItem
{
    /**
     * @param string $photo
     */
    public function __construct(
        protected string $photo
    ) {
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }
}
