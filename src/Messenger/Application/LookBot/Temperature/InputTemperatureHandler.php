<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class InputTemperatureHandler extends AbstractHandler
{

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        if ($context->getUser()) {
            $context->getUser()->setMessageHandler(TextAction::SaveTemperature->value);
            $message = Message::text('Введите температуру, для которой нужно найти образ');
        } else {
            $message = 'Произошла ошибка, попробуйте позднее';
        }

        $messenger->sendMessage($message);
    }
}
