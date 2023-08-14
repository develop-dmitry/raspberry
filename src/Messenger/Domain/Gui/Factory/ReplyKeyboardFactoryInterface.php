<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory;

use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface ReplyKeyboardFactoryInterface
{
    /**
     * @param OptionInterface $isResize
     * @return self
     */
    public function setResize(OptionInterface $isResize): self;

    /**
     * @return ReplyKeyboardInterface
     */
    public function make(): ReplyKeyboardInterface;
}
