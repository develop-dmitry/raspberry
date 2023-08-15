<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\SelectionLook;

use Raspberry\Look\Domain\Look\LookInterface;

interface SelectionLookServiceInterface
{

    /**
     * @return LookInterface[]
     */
    public function selection(): array;
}
