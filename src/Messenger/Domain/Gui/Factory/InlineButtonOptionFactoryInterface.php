<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory;

use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface InlineButtonOptionFactoryInterface
{
    /**
     * @param string $action
     * @param array $query
     * @return OptionInterface
     */
    public function makeCallbackDataOption(string $action, array $query): OptionInterface;
}
