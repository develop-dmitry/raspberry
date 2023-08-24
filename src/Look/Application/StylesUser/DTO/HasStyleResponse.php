<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser\DTO;

class HasStyleResponse
{

    /**
     * @param bool $hasStyle
     */
    public function __construct(
        protected bool $hasStyle
    ) {
    }

    /**
     * @return bool
     */
    public function hasStyle(): bool
    {
        return $this->hasStyle;
    }
}
