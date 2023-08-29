<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser\DTO;

class ToggleStyleResponse
{

    /**
     * @param bool $isAdded
     */
    public function __construct(
        protected bool $isAdded
    ) {
    }

    /**
     * @return bool
     */
    public function isAdded(): bool
    {
        return $this->isAdded;
    }
}
