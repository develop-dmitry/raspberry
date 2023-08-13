<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton\SendLocationOption;

class ReplyButtonOptionFactory implements ReplyButtonOptionFactoryInterface
{
    public function makeSendLocationOption(bool $value): OptionInterface
    {
        return new SendLocationOption($value);
    }
}
