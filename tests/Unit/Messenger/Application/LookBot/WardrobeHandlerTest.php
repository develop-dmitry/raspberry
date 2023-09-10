<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\RunningMode;
use Raspberry\Messenger\Infrastructure\Gui\Telegram\TelegramMessenger;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Testing\FakeNutgram;
use Tests\TestCase;

class WardrobeHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearText('Гардероб')
            ->reply()
            ->assertReplyMessage([
                'text' => 'Ваш гардероб',
                'reply_markup' => [
                    'keyboard' => [
                        [
                            [
                                'text' => 'Посмотреть гардероб',
                            ],
                        ],
                        [
                            [
                                'text' => 'Обновить гардероб',
                            ],
                        ],
                        [
                            [
                                'text' => 'Назад'
                            ],
                        ]
                    ]
                ]
            ]);
    }
}
