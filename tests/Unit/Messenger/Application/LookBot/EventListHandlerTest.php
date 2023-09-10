<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use Illuminate\Database\Eloquent\Casts\Json;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use SergiX44\Nutgram\Testing\FakeNutgram;

class EventListHandlerTest extends LookBotTestCase
{

    public function testHandlerFromTemperature(): void
    {
        $this->bot
            ->hearText('Подтвердить температуру')
            ->reply()
            ->assertSequence(
                fn (FakeNutgram $bot) => $bot->assertReplyText(
                    'Выберите мероприятие, для которого хотите подобрать образ'
                ),
                fn (FakeNutgram $bot) => $bot->assertReplyText('Список мероприятий')
            );
    }

    public function testHandlerFromCurrentHandler(): void
    {
        $this->bot
            ->hearCallbackQueryData(Json::encode(['action' => Action::EventList->value, 'pagination' => 1]))
            ->reply()
            ->assertReplyText('Список мероприятий');
    }
}
