<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Buttons\InlineButton;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface InlineButtonInterface
{
    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return OptionInterface
     */
    public function getCallbackData(): OptionInterface;
}
