<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Slug;

interface SlugInterface
{
    /**
     * @return string
     */
    public function getValue(): string;
}
