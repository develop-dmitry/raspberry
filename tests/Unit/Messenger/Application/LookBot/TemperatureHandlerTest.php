<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

class TemperatureHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearText('Подобрать образ')
            ->reply()
            ->assertReplyMessage([
                'text' => 'Отправьте ваше местоположения для получения погоды, либо введите вручную',
                'reply_markup' => [
                    'keyboard' => [
                        [
                            [
                                'text' => 'Ввести температуру вручную',
                            ],
                        ],
                        [
                            [
                                'text' => 'Отправить местоположение',
                            ],
                        ]
                    ]
                ]
            ]);
    }
}
