<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

use Raspberry\Look\Domain\Event\EventInterface;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class EventData extends DataTransferObject
{

    public string $name;

    /**
     * @param EventInterface $event
     * @return self
     * @throws UnknownProperties
     */
    public static function fromDomain(EventInterface $event): self
    {
        return new self(
            name: $event->getName()->getValue()
        );
    }
}
