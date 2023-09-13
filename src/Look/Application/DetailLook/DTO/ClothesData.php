<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ClothesData extends DataTransferObject
{

    public int $id;

    public string $photo;

    public string $name;

    /**
     * @param ClothesInterface $clothes
     * @return self
     * @throws UnknownProperties
     */
    public static function fromDomain(ClothesInterface $clothes): self
    {
        return new self(
            id: $clothes->getId()->getValue(),
            photo: $clothes->getPhoto()->getValue(),
            name: $clothes->getName()->getValue()
        );
    }
}
