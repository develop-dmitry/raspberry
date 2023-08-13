<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

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
