<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\EventHandlers;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;

class EventChooseHandler extends AbstractHandler
{
    use AuthorizeTrait;

    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        if (!$context->getUser()) {
            throw new FailedAuthorizeException();
        }

        $this->identifyUser($context->getUser()->getMessengerId());
    }
}
