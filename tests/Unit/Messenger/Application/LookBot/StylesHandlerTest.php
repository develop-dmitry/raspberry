<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Application\LookBot;

use Illuminate\Database\Eloquent\Casts\Json;

class StylesHandlerTest extends LookBotTestCase
{

    public function testHandlerWithTextTriggered(): void
    {
        $this->bot
            ->hearText('Предпочитаемые стили')
            ->reply()
            ->assertReply('sendMessage')
            ->assertReplyText('Выберите стили в одежде, которые вы предпочитаете');
    }

    public function testHandlerWithCallbackTriggered(): void
    {
        $this->bot
            ->hearCallbackQueryData(Json::encode(['action' => 'styles_choose']))
            ->reply()
            ->assertReply('editMessageText')
            ->assertReplyText('Выберите стили в одежде, которые вы предпочитаете');
    }
}
