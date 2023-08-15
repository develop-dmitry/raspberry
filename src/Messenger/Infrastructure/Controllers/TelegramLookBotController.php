<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuthorization\TelegramMessengerAuthorizationUseCase;
use Raspberry\Authorization\Application\MessengerRegister\TelegramMessengerRegisterUseCase;
use Raspberry\Messenger\Application\LookBot\HelloWorldHandler;
use Raspberry\Messenger\Application\LookBot\StartCommandHandler;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;
use Raspberry\Messenger\Infrastructure\Gateway\Exceptions\MessengerException;
use Raspberry\Messenger\Infrastructure\Gateway\TelegramMessengerGateway;

class TelegramLookBotController extends Controller
{
    public function __construct(
        protected LoggerInterface $logger,
        protected TelegramMessengerAuthorizationUseCase $messengerAuthorization,
        protected TelegramMessengerRegisterUseCase $messengerRegister
    ) {
    }

    public function __invoke(Request $request): void
    {
        $this->logger->debug('Request from telegram', $request->toArray());

        $telegram = app()->makeWith(TelegramMessengerGateway::class, ['handlers' => $this->getHandlers()]);

        try {
            $telegram->handleRequest();
        } catch (MessengerException $exception) {
            $this->logger->emergency(
                'Error while performing telegram request',
                ['exception' => $exception->getMessage()]
            );
        }
    }

    protected function getHandlers(): HandlerContainerInterface
    {
        $handlers = new HandlerContainer();

        $handlers
            ->addHandler(
                'start',
                HandlerTypeEnum::Command,
                $this->makeHandler(StartCommandHandler::class)
            );

        return $handlers;
    }

    protected function makeAuthHandler(string $class): mixed
    {
        return app()
            ->makeWith(
                $class,
                [
                    'messengerAuthorization' => $this->messengerAuthorization,
                    'messengerRegister' => $this->messengerRegister
                ]
            );
    }

    protected function makeHandler(string $class): mixed
    {
        return app()->make($class);
    }
}
