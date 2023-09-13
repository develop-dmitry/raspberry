<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look\Services\Picker;

use Raspberry\Look\Domain\Look\LookInterface;

interface PickerServiceInterface
{

    /**
     * @return LookInterface[]
     */
    public function pick(): array;
}
