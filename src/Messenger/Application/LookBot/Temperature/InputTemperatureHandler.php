<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;

class InputTemperatureHandler extends AbstractHandler
{

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        if ($context->getUser()) {
            $context->getUser()->setMessageHandler(TextAction::SaveTemperature->value);
            $gui->sendMessage('Введите температуру, для которой нужно найти образ')
                ->removeKeyboard();
        } else {
            $gui->sendMessage('Произошла ошибка, попробуйте позднее');
        }
    }
}
