<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Settings;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class SettingsHandler extends AbstractHandler
{

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $messenger->sendMessage(Message::withReplyKeyboard('Настройки', $this->makeSettingsKeyboard()));
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeSettingsKeyboard(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make()
            ->addRow($this->makeSettingsButton(SettingsMenu::Styles->getText()))
            ->addRow($this->makeSettingsButton(SettingsMenu::Back->getText()));
    }

    /**
     * @param string $text
     * @return ReplyButtonInterface
     */
    protected function makeSettingsButton(string $text): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->make();
    }
}
