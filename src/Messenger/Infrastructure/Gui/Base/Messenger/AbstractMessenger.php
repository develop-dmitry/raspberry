<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Base\Messenger;

use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthRequest;
use Raspberry\Authorization\Application\MessengerAuth\MessengerAuthInterface;
use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterRequest;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Geolocation\GeolocationInterface;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Token\Token;
use Raspberry\Messenger\Domain\Context\Context;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Context\Request\Request;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainerInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;
use Raspberry\Messenger\Domain\Messenger\MessengerInterface;
use Throwable;

abstract class AbstractMessenger implements MessengerInterface
{

    protected ContextInterface $context;

    protected HandlerContainerInterface $handlers;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param LoggerInterface $logger
     * @param MessengerGatewayInterface $gateway
     * @param MessengerAuthInterface $messengerAuthorization
     * @param MessengerRegisterInterface $messengerRegister
     */
    public function __construct(
        protected UserRepositoryInterface    $userRepository,
        protected LoggerInterface            $logger,
        protected MessengerGatewayInterface  $gateway,
        protected MessengerAuthInterface     $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister
    ) {
    }

    /**
     * @param callable $handler
     * @return void
     */
    protected function execute(callable $handler): void
    {
        $this->initContext();

        try {
            $handler();
        } catch (HandlerNotFoundException) {
            $this->gateway->sendMessage(Message::text('Я не знаю такой команды :('));
        }

        if ($user = $this->context->getUser()) {
            try {
                $this->userRepository->saveUser($user);
            } catch (RepositoryException $exception) {
                $this->logger->emergency('Troubles with repository', ['exception' => $exception->getMessage()]);
            }
        }
    }

    /**
     * @throws HandlerNotFoundException
     * @return void
     */
    protected function executeCallbackQueryHandler(): void
    {
        $callbackQuery = $this->context->getRequest()->getCallbackData();
        $handler = $this->handlers->getHandler($callbackQuery->getAction(), HandlerType::CallbackQuery);

        $this->executeHandler($handler);
    }

    /**
     * @throws HandlerNotFoundException
     * @return void
     */
    protected function executeMessageHandler(): void
    {
        $handlerName = ($user = $this->context->getUser()) ? $user->getMessageHandler() : '';
        $handler = $this->handlers->getHandler($handlerName, HandlerType::Message);

        $this->executeHandler($handler);
    }

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    protected function executeHandler(HandlerInterface $handler): void
    {
        try {
            if ($handler->isNeedAuthorize()) {
                $this->identifyUser();
            }

            $handler->handle($this->context, $this->gateway);
        } catch (FailedAuthorizeException) {
            $this->gateway->sendMessage(Message::text('Я вас не узнаю :('));
        } catch (Throwable $throwable) {
            $this->logger->emergency(
                'Unexpected error while execution messenger handler',
                ['exception' => $throwable->getMessage()]
            );

            $this->gateway->sendMessage(Message::text('Произошла ошибка, попробуйте позднее'));
        }
    }

    /**
     * @return void
     * @throws FailedAuthorizeException
     */
    protected abstract function identifyUser(): void;

    /**
     * @param int $messengerId
     * @return void
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    protected function authorizeUser(int $messengerId): void
    {
        $request = new MessengerAuthRequest($messengerId);
        $response = $this->messengerAuthorization->execute($request);

        $this->context->getUser()->authorize(
            new Id($response->getUserId()),
            new Token($response->getApiToken())
        );
    }

    /**
     * @param int $messengerId
     * @return void
     * @throws InvalidValueException
     * @throws FailedSaveUserException
     */
    protected function registerUser(int $messengerId): void
    {
        $request = new MessengerRegisterRequest($messengerId);
        $response = $this->messengerRegister->execute($request);

        $this->context->getUser()->authorize(
            new Id($response->getUserId()),
            new Token($response->getApiToken())
        );
    }

    protected function initContext(): void
    {
        $this->context = new Context($this->getRequest(), $this->getUser());
    }

    /**
     * @return RequestInterface
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
     * @return UserInterface|null
     */
    abstract protected function getUser(): ?UserInterface;

    /**
     * @return string
     */
    abstract protected function getMessage(): string;

    /**
     * @return CallbackDataInterface
     */
    abstract protected function getCallbackData(): CallbackDataInterface;

    /**
     * @return HandlerType
     */
    abstract protected function getRequestType(): HandlerType;

    /**
     * @return GeolocationInterface|null
     */
    abstract protected function getGeolocation(): ?GeolocationInterface;
}
