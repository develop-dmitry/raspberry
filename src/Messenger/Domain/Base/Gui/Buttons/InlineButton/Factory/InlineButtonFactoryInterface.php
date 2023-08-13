<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

interface InlineButtonFactoryInterface
{
    /**
     * @param string $text
     * @return self
     */
    public function setText(string $text): self;

    /**
     * @param OptionInterface $callbackData
     * @return self
     */
    public function setCallbackData(OptionInterface $callbackData): self;

    /**
     * @return InlineButtonInterface
     */
    public function make(): InlineButtonInterface;
}
