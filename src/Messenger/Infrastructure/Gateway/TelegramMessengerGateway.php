<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gateway;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\Geolocation;
use Raspberry\Common\Values\Geolocation\GeolocationInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackData;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\NullCallbackData;
use Raspberry\Messenger\Domain\Context\Request\Request;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Infrastructure\Gateway\Exceptions\MessengerException;
use Raspberry\Messenger\Infrastructure\Gui\Telegram\TelegramGui;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class TelegramMessengerGateway extends AbstractMessengerGateway
{

    protected TelegramGui $gui;

    /**
     * @param Nutgram $bot
     * @param HandlerContainer $handlers
     * @param UserRepositoryInterface $userRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected Nutgram $bot,
        HandlerContainer $handlers,
        UserRepositoryInterface $userRepository,
        LoggerInterface $logger
    ) {
        parent::__construct($handlers, $userRepository, $logger);

        $this->gui = app(TelegramGui::class);
    }

    /**
     * @inheritDoc
     */
    public function handleRequest(): void
    {
        $this->bot->setRunningMode(Webhook::class);

        foreach ($this->handlers->filterByType(HandlerType::Command) as $command => $handler) {
            $commandHandler = fn() => $this->executeHandler($handler);
            $this->bot->onCommand($command, fn() => $this->execute($commandHandler));
        }

        foreach ($this->handlers->filterByType(HandlerType::Text) as $pattern => $handler) {
            $textHandler = fn() => $this->executeHandler($handler);
            $this->bot->onText($pattern, fn() => $this->execute($textHandler));
        }

        $this->bot->onCallbackQuery(fn() => $this->execute([$this, 'executeCallbackQueryHandler']));

        $this->bot->onMessage(fn() => $this->execute([$this, 'executeMessageHandler']));

        try {
            $this->bot->run();
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $exception) {
            throw new MessengerException($exception->getMessage());
        }
    }

    /**
     * @return Message|bool|null
     */
    protected function makeResponse(): Message|bool|null
    {
        $message = $this->gui->getMessage();
        $keyboard = $this->gui->makeTelegramKeyboard();

        if ($this->gui->isEditMessage()) {
            return $this->bot->editMessageText(
                $message,
                $this->bot->chatId(),
                $this->bot->messageId(),
                reply_markup: $keyboard
            );
        }

        return $this->bot->sendMessage($message, reply_markup: $keyboard);
    }

    /**
     * @return GuiInterface
     */
    protected function gui(): GuiInterface
    {
        return $this->gui;
    }

    /**
     * @inheritDoc
     */
    protected function getRequest(): RequestInterface
    {
        return new Request(
            $this->getMessage(),
            $this->getCallbackData(),
            $this->getRequestType(),
            $this->getGeolocation()
        );
    }

    /**
     * @return string
     */
    protected function getMessage(): string
    {
        if (!is_null($this->bot->message()?->getText())) {
            return $this->bot->message()?->getText();
        }

        return '';
    }

    /**
     * @return GeolocationInterface|null
     */
    protected function getGeolocation(): ?GeolocationInterface
    {
        if ($location = $this->bot->message()->location) {
            try {
                return new Geolocation($location->latitude, $location->longitude);
            } catch (InvalidValueException) {
                return null;
            }
        }

        return null;
    }

    /**
     * @return CallbackDataInterface
     */
    protected function getCallbackData(): CallbackDataInterface
    {
        if ($callbackData = $this->bot->callbackQuery()?->data) {
            return CallbackData::fromJson($callbackData);
        }

        return new NullCallbackData();
    }

    /**
     * @return HandlerType
     */
    protected function getRequestType(): HandlerType
    {
        if ($this->bot->isCommand()) {
            return HandlerType::Command;
        }

        if ($this->bot->isCallbackQuery()) {
            return HandlerType::CallbackQuery;
        }

        return HandlerType::Message;
    }

    /**
     * @inheritDoc
     */
    protected function getUser(): ?UserInterface
    {
        if ($userId = $this->bot->userId()) {
            try {
                return $this->userRepository->getUserByMessengerId($userId);
            } catch (RepositoryException $exception) {
                $this->logger->emergency('Troubles with repository', ['exception' => $exception->getMessage()]);
            }
        }

        return null;
    }
}
