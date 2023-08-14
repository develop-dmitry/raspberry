<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\Factory;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;

class ReplyKeyboardOptionFactory implements ReplyKeyboardOptionFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function makeResizeOption(bool $isResize): OptionInterface
    {
        return new ResizeOption($isResize);
    }
}
