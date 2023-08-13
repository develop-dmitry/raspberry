<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;

interface InlineKeyboardFactoryInterface
{
    /**
     * @return InlineKeyboardInterface
     */
    public function make(): InlineKeyboardInterface;
}
