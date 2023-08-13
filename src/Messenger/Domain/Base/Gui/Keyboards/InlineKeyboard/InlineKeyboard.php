<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard;

use Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\KeyboardTrait;

class InlineKeyboard implements InlineKeyboardInterface
{
    use KeyboardTrait;

    /**
     * @var InlineButtonInterface[][]
     */
    protected array $rows = [];
}
