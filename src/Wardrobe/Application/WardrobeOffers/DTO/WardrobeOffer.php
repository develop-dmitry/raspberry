<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers\DTO;

class WardrobeOffer
{
    /**
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param string $photo
     */
    public function __construct(
        protected int $id,
        protected string $name,
        protected string $slug,
        protected string $photo
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
}
