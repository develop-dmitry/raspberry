<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Buttons;

trait ButtonTrait
{
    public function getText(): string
    {
        return $this->text;
    }
}
