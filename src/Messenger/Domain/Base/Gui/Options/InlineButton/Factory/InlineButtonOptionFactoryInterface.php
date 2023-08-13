<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton\Factory;

use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

interface InlineButtonOptionFactoryInterface
{
    /**
     * @param string $action
     * @param array $query
     * @return OptionInterface
     */
    public function makeCallbackDataOption(string $action, array $query): OptionInterface;
}
