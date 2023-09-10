<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Casts\Json;
use Raspberry\Messenger\Application\LookBot\Enums\Action;

class SelectionLookHandlerTest extends LookBotTestCase
{

    public function testHandler(): void
    {
        $this->bot
            ->hearCallbackQueryData(Json::encode(['action' => Action::EventChoose->value, 'id' => 1]))
            ->reply()
            ->assertReply('editMessageText')
            ->assertRaw(function (Request $request) {
                $data = Json::decode($request->getBody());

                return $data['text'] === 'К сожалению, мы не смогли подобрать для вас образ :('
                    || $data['text'] === 'Для вас подобраны следующие образы';
            });
    }
}
