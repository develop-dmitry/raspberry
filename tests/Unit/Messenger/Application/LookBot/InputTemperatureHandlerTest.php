<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

class InputTemperatureHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearText('Ввести температуру вручную')
            ->reply()
            ->assertReplyText('Введите температуру, для которой нужно найти образ');
    }
}
