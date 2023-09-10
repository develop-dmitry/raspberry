<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

class SettingsHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearText('Настройки')
            ->reply()
            ->assertReplyMessage([
                'text' => 'Настройки',
                'reply_markup' => [
                    'keyboard' => [
                        [
                            [
                                'text' => 'Предпочитаемые стили'
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
