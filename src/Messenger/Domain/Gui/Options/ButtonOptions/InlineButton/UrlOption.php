<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\InlineButton;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Gui\Options\OptionTrait;

class UrlOption implements OptionInterface
{
    use OptionTrait;

    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
