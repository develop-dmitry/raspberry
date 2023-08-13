<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gateway;

use Psr\Log\LoggerInterface;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Messenger\Domain\Base\Context\ContextInterface;
use Raspberry\Messenger\Domain\Base\Context\Request\CallbackData\CallbackData;
use Raspberry\Messenger\Domain\Base\Context\Request\CallbackData\NullCallbackData;
use Raspberry\Messenger\Domain\Base\Context\Request\Request;
use Raspberry\Messenger\Domain\Base\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Base\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Base\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Base\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Base\Handlers\HandlerTypeEnum;
use Raspberry\Messenger\Domain\Telegram\Gui\TelegramGui;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class TelegramMessengerGateway extends AbstractMessengerGateway
{

    protected TelegramGui $gui;

    protected ContextInterface $context;

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

        $this->gui = new TelegramGui();
    }

    /**
     * @inheritDoc
     */
    public function handleRequest(): void
    {
        $this->bot->setRunningMode(Webhook::class);

        foreach ($this->handlers->filterByType(HandlerTypeEnum::Command) as $command => $handler) {
            $commandHandler = fn() => $this->executeHandler($handler);
            $this->bot->onCommand($command, fn() => $this->execute($commandHandler));
        }

        foreach ($this->handlers->filterByType(HandlerTypeEnum::Text) as $pattern => $handler) {
            $textHandler = fn() => $this->executeHandler($handler);
            $this->bot->onText($pattern, fn() => $this->execute($textHandler));
        }

        $this->bot->onCallbackQuery(fn() => $this->execute([$this, 'executeCallbackQueryHandler']));

        $this->bot->onMessage(fn() => $this->execute([$this, 'executeMessageHandler']));

        $this->bot->run();
    }

    /**
     * @return Message|bool|null
     */
    protected function makeResponse(): Message|bool|null
    {
        $message = $this->gui->getMessage();
        $keyboard = $this->gui->makeTelegramKeyboard();

        if ($this->gui->isEditMessage()) {
            return $this->bot->editMessageText($message, reply_markup: $keyboard);
        }

        return $this->bot->sendMessage($message, reply_markup: $keyboard);
    }

    protected function gui(): GuiInterface
    {
        return $this->gui;
    }

    /**
     * @inheritDoc
     */
    protected function getRequest(): RequestInterface
    {
        if ($callbackData = $this->bot->callbackQuery()?->data) {
            $callbackData = CallbackData::fromJson($callbackData);
        } else {
            $callbackData = new NullCallbackData();
        }

        return new Request($this->bot->message()?->getText() ?: '', $callbackData);
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
