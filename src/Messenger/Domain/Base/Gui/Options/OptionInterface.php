<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options;

interface OptionInterface
{
    public function getValue(): mixed;
}
