<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Base\Factory;

use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\UrlOption;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\WebAppOption;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class InlineButtonOptionFactory implements InlineButtonOptionFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function makeCallbackDataOption(string $action, array $query): OptionInterface
    {
        return new CallbackDataOption($action, $query);
    }

    /**
     * @inheritDoc
     */
    public function makeWebAppOption(string $url): OptionInterface
    {
        return new WebAppOption($url);
    }

    /**
     * @inheritDoc
     */
    public function makeUrlOption(string $url): OptionInterface
    {
        return new UrlOption($url);
    }
}
