<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\Factory;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface ReplyKeyboardOptionFactoryInterface
{
    /**
     * @param bool $isResize
     * @return OptionInterface
     */
    public function makeResizeOption(bool $isResize): OptionInterface;
}
