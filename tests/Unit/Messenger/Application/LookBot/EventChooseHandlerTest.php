<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use App\Models\Event;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Messenger\Application\LookBot\Enums\Action;

class EventChooseHandlerTest extends LookBotTestCase
{
    use DatabaseTransactions;

    public function testHandler(): void
    {
        $event = Event::factory(1)->create()->first();

        $this->bot
            ->hearCallbackQueryData(Json::encode([
                'action' => Action::EventChoose->value,
                'id' => $event->id
            ]))
            ->reply()
            ->assertReply('editMessageText');
    }

    public function testHandlerWhenEventIdDoesNotExists(): void
    {
        $this->bot
            ->hearCallbackQueryData(Json::encode(['action' => Action::EventChoose->value]))
            ->reply()
            ->assertReply('editMessageText');
    }
}
