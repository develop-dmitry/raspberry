<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

interface ReplyButtonOptionFactoryInterface
{
    public function makeSendLocationOption(bool $value): OptionInterface;
}
