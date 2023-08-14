<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard;

use Raspberry\Messenger\Domain\Gui\Keyboards\KeyboardTrait;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class ReplyKeyboard implements ReplyKeyboardInterface
{
    use KeyboardTrait;

    /**
     * @var ReplyKeyboardInterface[][]
     */
    protected array $rows = [];

    public function __construct(
        protected OptionInterface $isResize
    ) {
    }

    /**
     * @inheritDoc
     */
    public function isResize(): OptionInterface
    {
        return $this->isResize;
    }
}
