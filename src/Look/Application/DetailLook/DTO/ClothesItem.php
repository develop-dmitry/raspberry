<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

class ClothesItem
{
    /**
     * @param int $id
     * @param string $photo
     * @param string $name
     */
    public function __construct(
        protected int $id,
        protected string $photo,
        protected string $name
    ) {
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
