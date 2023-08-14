<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Buttons\InlineButton;

use Raspberry\Messenger\Domain\Gui\Buttons\ButtonTrait;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class InlineButton implements InlineButtonInterface
{
    use ButtonTrait;

    public function __construct(
        protected string $text,
        protected OptionInterface $callbackData
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCallbackData(): OptionInterface
    {
        return $this->callbackData;
    }
}
