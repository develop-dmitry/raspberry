<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

class StartHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearText('/start')
            ->reply()
            ->assertReplyMessage([
                'text' => 'Добро пожаловать в Raspberry!',
                'reply_markup' => [
                    'keyboard' => [
                        [
                            [
                                'text' => 'Подобрать образ'
                            ],
                        ],
                        [
                            [
                                'text' => 'Гардероб'
                            ],
                        ],
                        [
                            [
                                'text' => 'Настройки'
                            ],
                        ]
                    ]
                ]
            ]);
    }
}
