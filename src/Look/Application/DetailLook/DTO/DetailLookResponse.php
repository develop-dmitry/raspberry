<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

class DetailLookResponse
{
    /**
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param string $photo
     * @param ClothesItem[] $clothes
     * @param array $events
     */
    public function __construct(
        protected int $id,
        protected string $name,
        protected string $slug,
        protected string $photo,
        protected array $clothes,
        protected array $events
    ) {
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

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @return ClothesItem[]
     */
    public function getClothes(): array
    {
        return $this->clothes;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
