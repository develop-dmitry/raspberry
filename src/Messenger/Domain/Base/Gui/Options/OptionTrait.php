<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options;

trait OptionTrait
{
    public function getValue(): mixed
    {
        return $this->value;
    }
}
