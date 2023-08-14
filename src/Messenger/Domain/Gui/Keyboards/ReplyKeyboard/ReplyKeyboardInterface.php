<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface ReplyKeyboardInterface
{
    /**
     * @return ReplyKeyboardInterface[][]
     */
    public function getRows(): array;

    /**
     * @param ReplyKeyboardInterface ...$button
     * @return ReplyKeyboardInterface
     */
    public function addRow(ReplyKeyboardInterface ...$button): self;

    /**
     * @return OptionInterface
     */
    public function isResize(): OptionInterface;
}
