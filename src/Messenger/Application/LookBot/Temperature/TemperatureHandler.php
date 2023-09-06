<?php

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\ReplyButton\SendLocationOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

class TemperatureHandler extends AbstractHandler
{
    use AuthorizeTrait;

    public function __construct(
        protected HandlerInterface $weatherGatewayHandler
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        if ($this->contextUser?->getGeolocation()) {
            $this->weatherGatewayHandler->handle($context, $gui);
        } else {
            $gui->sendMessage('Отправьте ваше местопололожения для получения погоды, либо введите вручную')
                ->sendReplyKeyboard($this->makeKeyboard());
            $this->contextUser?->setMessageHandler(TextAction::GatewayTemperature->value);
        }
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeKeyboard(): ReplyKeyboardInterface
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

    protected function makeButton(string $text): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->make();
    }
}
