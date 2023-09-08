<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gateway;

use Raspberry\Messenger\Domain\Gui\Message\MessageInterface;
use Raspberry\Messenger\Domain\Gui\Messenger\MessengerGatewayInterface;
use Raspberry\Messenger\Infrastructure\Gui\Telegram\TelegramAdapter;
use SergiX44\Nutgram\Nutgram;

class TelegramMessengerGateway implements MessengerGatewayInterface
{

    /**
     * @param Nutgram $bot
     */
    public function __construct(
        protected Nutgram $bot,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(MessageInterface $message): void
    {
        $adapter = new TelegramAdapter($message);

        $this->bot->sendMessage(
            $adapter->makeText(),
            chat_id: $this->bot->chatId(),
            reply_markup: $adapter->makeTelegramKeyboard()
        );
    }

    /**
     * @inheritDoc
     */
    public function editMessage(MessageInterface $message): void
    {
        $adapter = new TelegramAdapter($message);

        $this->bot->editMessageText(
            $adapter->makeText(),
            chat_id: $this->bot->chatId(),
            message_id: $this->bot->messageId(),
            reply_markup: $adapter->makeTelegramKeyboard()
        );
    }
}
