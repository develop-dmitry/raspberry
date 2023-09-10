<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Common;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\Menu;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class StartHandler extends AbstractHandler
{

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $message = Message::withReplyKeyboard('Добро пожаловать в Raspberry!', $this->makeMenu());
        $messenger->sendMessage($message);
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeMenu(): ReplyKeyboardInterface
    {
        $keyboard = $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make();

        foreach (Menu::cases() as $item) {
            $keyboard->addRow($this->makeMenuButton($item->getText()));
        }

        return $keyboard;
    }

    /**
     * @param string $text
     * @return ReplyButtonInterface
     */
    protected function makeMenuButton(string $text): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->make();
    }
}
