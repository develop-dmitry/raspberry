<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\LookSelection;

use Raspberry\Look\Domain\Look\LookInterface;

interface LookSelectionServiceInterface
{

    /**
     * @return LookInterface[]
     */
    public function selection(): array;
}
