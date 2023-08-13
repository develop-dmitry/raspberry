<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard;

use Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\InlineButtonInterface;

interface InlineKeyboardInterface
{
    /**
     * @return InlineButtonInterface[][]
     */
    public function getRows(): array;

    /**
     * @param InlineButtonInterface ...$button
     * @return void
     */
    public function addRow(InlineButtonInterface ...$button): void;
}
