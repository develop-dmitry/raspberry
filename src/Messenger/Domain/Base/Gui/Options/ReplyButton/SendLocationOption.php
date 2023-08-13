<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\OptionTrait;

class SendLocationOption implements OptionInterface
{
    use OptionTrait;

    public function __construct(
        protected bool $value
    ) {
    }
}
