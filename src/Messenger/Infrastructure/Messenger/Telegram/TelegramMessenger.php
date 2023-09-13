<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Messenger\Telegram;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuth\TelegramMessengerAuth;
use Raspberry\Authorization\Application\MessengerRegister\TelegramMessengerRegister;
use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\RepositoryException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Core\Values\Geolocation\Geolocation;
use Raspberry\Core\Values\Geolocation\GeolocationInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackData;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\NullCallbackData;
use Raspberry\Messenger\Domain\Context\Request\Request;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainerInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\Exceptions\MessengerException;
use Raspberry\Messenger\Domain\Messenger\RunningMode;
use Raspberry\Messenger\Infrastructure\Gateway\TelegramMessengerGateway;
use Raspberry\Messenger\Domain\Messenger\AbstractMessenger;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;

class TelegramMessenger extends AbstractMessenger
{

    /**
     * @param Nutgram $bot
     * @param UserRepositoryInterface $userRepository
     * @param TelegramMessengerAuth $messengerAuthorization
     * @param TelegramMessengerRegister $messengerRegister
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected Nutgram         $bot,
        UserRepositoryInterface   $userRepository,
        TelegramMessengerAuth     $messengerAuthorization,
        TelegramMessengerRegister $messengerRegister,
        LoggerInterface           $logger,
    ) {
        $gateway = new TelegramMessengerGateway($this->bot);

        parent::__construct(
            $userRepository,
            $logger,
            $gateway,
            $messengerAuthorization,
            $messengerRegister
        );
    }

    /**
     * @inheritDoc
     */
    public function handle(RunningMode $mode): void
    {
        if ($mode === RunningMode::Webhook) {
            $this->bot->setRunningMode(Webhook::class);

            try {
                $this->bot->run();
            } catch (NotFoundExceptionInterface|ContainerExceptionInterface|Exception $exception) {
                throw new MessengerException($exception->getMessage());
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function setHandlers(HandlerContainerInterface $handlers): void
    {
        $this->handlers = $handlers;

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
    }

    /**
     * @inheritDoc
     */
    protected function identifyUser(): void
    {
        if (!$this->bot->userId()) {
            throw new FailedAuthorizeException();
        }

        try {
            $this->authorizeUser($this->bot->userId());
        } catch (UserNotFoundException) {
            $this->registerUser($this->bot->userId());
        } catch (InvalidValueException|FailedSaveUserException) {
            throw new FailedAuthorizeException();
        }
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
     * @inheritDoc
     */
    protected function getMessage(): string
    {
        if (!is_null($this->bot->message()?->getText())) {
            return $this->bot->message()?->getText();
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    protected function getCallbackData(): CallbackDataInterface
    {
        if ($callbackData = $this->bot->callbackQuery()?->data) {
            return CallbackData::fromJson($callbackData);
        }

        return new NullCallbackData();
    }

    /**
     * @inheritDoc
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
