<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard;

use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;

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
    public function addRow(InlineButtonInterface ...$button): self;
}
