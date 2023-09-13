<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\ReplyButton\SendLocationOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class TemperatureHandler extends AbstractHandler
{

    /**
     * @param WeatherGatewayHandler $weatherGatewayHandler
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected WeatherGatewayHandler $weatherGatewayHandler,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @return bool
     */
    public function isNeedAuthorize(): bool
    {
        return $this->weatherGatewayHandler->isNeedAuthorize();
    }

    /**
     * @inheritDoc
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
