<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use Raspberry\Messenger\Application\LookBot\LookBot;
use Raspberry\Messenger\Infrastructure\Messenger\Telegram\TelegramMessenger;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Testing\FakeNutgram;
use Tests\TestCase;

class LookBotTestCase extends TestCase
{

    protected FakeNutgram $bot;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bot = Nutgram::fake();
        $this->bootInstance($this->bot);
    }

    protected function bootInstance(FakeNutgram $bot): void
    {
        $messenger = app(TelegramMessenger::class, ['bot' => $bot]);
        app(LookBot::class, ['messenger' => $messenger]);
    }
}
