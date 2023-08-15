<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook\DTO;

class SelectionLookResponse
{

    /**
     * @param LookItem[] $looks
     */
    public function __construct(
        protected array $looks
    ) {
    }

    /**
     * @return array
     */
    public function getLooks(): array
    {
        return $this->looks;
    }
}
