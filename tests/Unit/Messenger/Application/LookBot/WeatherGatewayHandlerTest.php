<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Casts\Json;

class WeatherGatewayHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearMessage($this->data('Подобрать образ'))
            ->reply()
            ->hearMessage($this->data('test', ['longitude' => 57, 'latitude' => 37]))
            ->reply()
            ->assertRaw(function (Request $request) {
                $data = Json::decode($request->getBody());

                return (bool) preg_match("/Ваше местоположение\s.+\nТемпература\s.+/m", $data['text']);
            });
    }

    public function testHandlerWithoutGeolocation(): void
    {
        $this->bot
            ->hearMessage($this->data('Подобрать образ'))
            ->reply()
            ->hearMessage($this->data('Геолокация'))
            ->reply()
            ->assertReplyText('Не удалось получить местоположение');
    }

    protected function data(string $text, array $location = []): array
    {
        $data = [
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

        if (!empty($location)) {
            $data['location'] = $location;
        }

        return $data;
    }
}
