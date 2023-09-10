<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

class SaveTemperatureHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearMessage($this->data('Ввести температуру вручную'))
            ->reply()
            ->hearMessage($this->data('+10'))
            ->reply()
            ->assertReply('sendMessage');
    }

    public function testHandlerWithInvalidTemperature(): void
    {
        $this->bot
            ->hearMessage($this->data('Ввести температуру вручную'))
            ->reply()
            ->hearMessage($this->data('test'))
            ->reply()
            ->assertReplyText('Введена некорректная температура, попробуйте еще раз');
    }

    protected function data(string $text): array
    {
        return [
            'text' => $text,
            'message_id' => 1234,
            'date' => 1647284950,
            'from' => [
                'id' => 123456789,
                'is_bot' => true,
                'username' => 'nutgrambot',
                'first_name' => 'nutgrambot',
            ],
            'chat' => [
                'id' => 12345,
                'type' => 'private',
                'username' => 'nutgram',
                'first_name' => 'foo',
                'last_name' => 'bar',
            ]
        ];
    }
}
