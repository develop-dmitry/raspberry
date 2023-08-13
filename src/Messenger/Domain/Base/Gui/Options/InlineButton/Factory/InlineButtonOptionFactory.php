<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

class InlineButtonOptionFactory implements InlineButtonOptionFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function makeCallbackDataOption(string $action, array $query): OptionInterface
    {
        return new CallbackDataOption($action, $query);
    }
}
