<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface ReplyButtonOptionFactoryInterface
{
    public function makeSendLocationOption(bool $value): OptionInterface;
}
