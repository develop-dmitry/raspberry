<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Gui\Options\OptionTrait;

class ResizeOption implements OptionInterface
{
    use OptionTrait;

    public function __construct(
        protected bool $value
    ) {
    }
}
