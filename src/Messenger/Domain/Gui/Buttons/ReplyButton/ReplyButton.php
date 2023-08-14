<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton;

use Raspberry\Messenger\Domain\Gui\Buttons\ButtonTrait;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class ReplyButton implements ReplyButtonInterface
{
    use ButtonTrait;

    public function __construct(
        protected string $text,
        protected OptionInterface $sendLocation
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getSendLocation(): OptionInterface
    {
        return $this->sendLocation;
    }
}
