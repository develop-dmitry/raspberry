<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options;

interface OptionInterface
{
    public function getValue(): mixed;
}
