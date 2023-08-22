<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

class EventItem
{

    /**
     * @param string $name
     */
    public function __construct(
        protected string $name
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
