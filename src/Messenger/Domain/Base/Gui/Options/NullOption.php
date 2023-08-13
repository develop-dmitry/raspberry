<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options;

class NullOption implements OptionInterface
{
    public function getValue(): mixed
    {
        return null;
    }
}
