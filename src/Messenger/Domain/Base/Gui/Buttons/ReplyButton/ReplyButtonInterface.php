<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Buttons\ReplyButton;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

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
