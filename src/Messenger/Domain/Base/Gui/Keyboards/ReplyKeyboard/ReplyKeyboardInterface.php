<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

interface ReplyKeyboardInterface
{
    /**
     * @return ReplyKeyboardInterface[][]
     */
    public function getRows(): array;

    /**
     * @param ReplyKeyboardInterface ...$button
     * @return void
     */
    public function addRow(ReplyKeyboardInterface ...$button): void;

    /**
     * @return OptionInterface
     */
    public function isResize(): OptionInterface;
}
