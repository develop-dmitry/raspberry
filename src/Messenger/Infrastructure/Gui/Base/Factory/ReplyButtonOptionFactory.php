<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Base\Factory;

use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Gui\Options\ReplyButton\SendLocationOption;

class ReplyButtonOptionFactory implements ReplyButtonOptionFactoryInterface
{
    public function makeSendLocationOption(bool $value): OptionInterface
    {
        return new SendLocationOption($value);
    }
}
