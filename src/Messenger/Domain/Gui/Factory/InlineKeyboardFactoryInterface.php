<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory;

use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;

interface InlineKeyboardFactoryInterface
{
    /**
     * @return InlineKeyboardInterface
     */
    public function make(): InlineKeyboardInterface;
}
