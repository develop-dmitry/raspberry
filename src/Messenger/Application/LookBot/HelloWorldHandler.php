<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;

class HelloWorldHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        $gui->sendMessage('Hello world');
    }
}
