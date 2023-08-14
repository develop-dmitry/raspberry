<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface ReplyButtonInterface
{
    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return OptionInterface
     */
    public function getSendLocation(): OptionInterface;
}
