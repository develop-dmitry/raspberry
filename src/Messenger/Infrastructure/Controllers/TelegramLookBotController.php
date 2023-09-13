<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Raspberry\Messenger\Application\LookBot\LookBot;
use Raspberry\Messenger\Domain\Messenger\RunningMode;
use Raspberry\Messenger\Infrastructure\Messenger\Telegram\TelegramMessenger;

class TelegramLookBotController extends Controller
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
    }

    public function __invoke(Request $request): void
    {
        $this->logger->debug('Request from telegram', $request->toArray());

        $bot = app(LookBot::class, ['messenger' => app(TelegramMessenger::class)]);

        try {
            $bot->handle(RunningMode::Webhook);
        } catch (Exception $exception) {
            $this->logger->emergency(
                'Error while performing telegram request',
                ['exception' => $exception->getMessage()]
            );
        }
    }
}
