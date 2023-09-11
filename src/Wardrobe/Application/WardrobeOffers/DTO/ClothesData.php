<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers\DTO;

use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ClothesData extends DataTransferObject
{

    public int $id;

    public string $name;

    public string $slug;

    public string $photo;

    /**
     * @param ClothesInterface $clothes
     * @return self
     * @throws UnknownProperties
     */
    public static function fromDomain(ClothesInterface $clothes): self
    {
        return new self(
            id: $clothes->getId()->getValue(),
            name: $clothes->getName()->getValue(),
            slug: $clothes->getSlug()->getValue(),
            photo: $clothes->getPhoto()->getValue()
        );
    }
}
