<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\InlineKeyboard;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;

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
