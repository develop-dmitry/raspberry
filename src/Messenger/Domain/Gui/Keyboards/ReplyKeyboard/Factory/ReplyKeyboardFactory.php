<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\Factory;

use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboard;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\NullOption;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class ReplyKeyboardFactory implements ReplyKeyboardFactoryInterface
{
    protected ?OptionInterface $isResize;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * @inheritDoc
     */
    public function setResize(OptionInterface $isResize): ReplyKeyboardFactoryInterface
    {
        $this->isResize = $isResize;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function make(): ReplyKeyboardInterface
    {
        $keyboard = new ReplyKeyboard($this->isResize());

        $this->reset();

        return $keyboard;
    }

    protected function isResize(): OptionInterface
    {
        return $this->isResize ?: new NullOption();
    }

    protected function reset(): void
    {
        $this->isResize = null;
    }
}
