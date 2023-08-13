<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Raspberry\Messenger\Domain\Base\Context\ContextInterface;
use Raspberry\Messenger\Domain\Base\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Base\Handlers\AbstractHandler;

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
