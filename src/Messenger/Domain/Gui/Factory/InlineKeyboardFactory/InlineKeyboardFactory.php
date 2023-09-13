<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory;

use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboard;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;

class InlineKeyboardFactory implements InlineKeyboardFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function make(): InlineKeyboardInterface
    {
        return new InlineKeyboard();
    }
}
