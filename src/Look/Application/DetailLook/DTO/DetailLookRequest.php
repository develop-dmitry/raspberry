<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook\DTO;

class DetailLookRequest
{
    /**
     * @param int $id
     */
    public function __construct(
        protected int $id
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
