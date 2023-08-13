<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Buttons\ReplyButton\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

interface ReplyButtonFactoryInterface
{
    /**
     * @param string $text
     * @return self
     */
    public function setText(string $text): self;

    /**
     * @param OptionInterface $sendLocation
     * @return self
     */
    public function setSendLocation(OptionInterface $sendLocation): self;

    /**
     * @return ReplyButtonInterface
     */
    public function make(): ReplyButtonInterface;
}
