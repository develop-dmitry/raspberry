<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gateway;

use Psr\Log\LoggerInterface;
use Raspberry\Common\Exceptions\RepositoryException;
use Raspberry\Messenger\Domain\Context\Context;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;
use Throwable;

abstract class AbstractMessengerGateway implements MessengerGatewayInterface
{

    protected ContextInterface $context;

    public function __construct(
        protected HandlerContainer $handlers,
        protected UserRepositoryInterface $userRepository,
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @param callable $handler
     * @return mixed
     */
    protected function execute(callable $handler): mixed
    {
        $this->initContext();

        try {
            $handler();
        } catch (HandlerNotFoundException) {
            $this->gui()->sendMessage('Я не знаю такой команды :(');
        }

        if ($user = $this->context->getUser()) {
            try {
                $this->userRepository->saveUser($user);
            } catch (RepositoryException $exception) {
                $this->logger->emergency('Troubles with repository', ['exception' => $exception->getMessage()]);
            }
        }

        return $this->makeResponse();
    }

    /**
     * @throws HandlerNotFoundException
     * @return void
     */
    protected function executeCallbackQueryHandler(): void
    {
        $callbackQuery = $this->context->getRequest()->getCallbackData();
        $handler = $this->handlers->getHandler($callbackQuery->getAction(), HandlerTypeEnum::CallbackQuery);

        $this->executeHandler($handler);
    }

    /**
     * @throws HandlerNotFoundException
     * @return void
     */
    protected function executeMessageHandler(): void
    {
        $handlerName = ($user = $this->context->getUser()) ? $user->getMessageHandler() : '';
        $handler = $this->handlers->getHandler($handlerName, HandlerTypeEnum::Message);

        $this->executeHandler($handler);
    }

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    protected function executeHandler(HandlerInterface $handler): void
    {
        try {
            $handler->handle($this->context, $this->gui());
        } catch (FailedAuthorizeException) {
            $this->gui()->sendMessage('Я вас не узнаю :(');
        } catch (Throwable $throwable) {
            $this->gui()->sendMessage('Произошла ошибка, попробуйте позднее');

            $this->logger->emergency(
                'Unexpected error while execution messenger handler',
                ['exception' => $throwable->getMessage()]
            );
        }
    }

    protected function initContext(): void
    {
        $this->context = new Context($this->getRequest(), $this->getUser());
    }

    /**
     * @return mixed
     */
    abstract protected function makeResponse(): mixed;

    /**
     * @return RequestInterface
     */
    abstract protected function getRequest(): RequestInterface;

    /**
     * @return UserInterface|null
     */
    abstract protected function getUser(): ?UserInterface;

    /**
     * @return GuiInterface
     */
    abstract protected function gui(): GuiInterface;
}
