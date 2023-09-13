<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\Picker\DTO;

use Raspberry\Look\Domain\Look\LookInterface;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LookData extends DataTransferObject
{

    public int $id;

    public string $name;

    public string $photo;

    /**
     * @param LookInterface $look
     * @return self
     * @throws UnknownProperties
     */
    public static function fromDomain(LookInterface $look): self
    {
        return new self(
            id: $look->getId()->getValue(),
            name: $look->getName()->getValue(),
            photo: $look->getPhoto()->getValue()
        );
    }
}
