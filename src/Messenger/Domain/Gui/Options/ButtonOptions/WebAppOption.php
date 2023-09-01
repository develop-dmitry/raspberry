<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options\ButtonOptions;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Gui\Options\OptionTrait;

class WebAppOption implements OptionInterface
{
    use OptionTrait;

    protected string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
