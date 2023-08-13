<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

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
