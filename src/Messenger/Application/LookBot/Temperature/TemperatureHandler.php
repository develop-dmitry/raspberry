<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\HasAuthorize;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Messenger\MessengerGatewayInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\ReplyButton\SendLocationOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

class TemperatureHandler extends AbstractHandler
{
    use HasAuthorize;

    public function __construct(
        protected HandlerInterface $weatherGatewayHandler,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @param ContextInterface $context
     * @param MessengerGatewayInterface $messenger
     * @return void
     * @throws FailedAuthorizeException
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        if ($this->contextUser?->getGeolocation()) {
            $this->weatherGatewayHandler->handle($context, $messenger);
        } else {
            $message = Message::withReplyKeyboard(
                'Отправьте ваше местоположения для получения погоды, либо введите вручную',
                $this->makeTemperatureMenu()
            );
            $messenger->sendMessage($message);
            $this->contextUser?->setMessageHandler(TextAction::GatewayTemperature->value);
        }
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeTemperatureMenu(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make()
            ->addRow(
                $this->replyButtonFactory
                    ->setText(TemperatureMenu::Input->getText())
                    ->make()
            )
            ->addRow(
                $this->replyButtonFactory
                    ->setText(TemperatureMenu::Gateway->getText())
                    ->setSendLocation(new SendLocationOption(true))
                    ->make()
            );
    }
}
