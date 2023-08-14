<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Options\ReplyButton\Factory;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyButton\SendLocationOption;

class ReplyButtonOptionFactory implements ReplyButtonOptionFactoryInterface
{
    public function makeSendLocationOption(bool $value): OptionInterface
    {
        return new SendLocationOption($value);
    }
}
