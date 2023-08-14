<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Domain\Gui\Options\InlineButton;

use Illuminate\Database\Eloquent\Casts\Json;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\CallbackDataOption;
use Tests\TestCase;

class CallbackDataOptionTest extends TestCase
{
    public function testJsonEncodeValue(): void
    {
        $action = 'test';
        $query = ['param1' => 'value1', 'param2' => 'value2'];

        $args = array_merge(['action' => $action], $query);
        $callbackDataOption = new CallbackDataOption($action, $query);

        $this->assertJson($callbackDataOption->getValue(), Json::encode($args));
    }

    public function testRedefineAction(): void
    {
        $action = 'test';
        $query = ['action' => 'test2'];

        $callbackDataOption = new CallbackDataOption($action, $query);

        $this->assertJson($callbackDataOption->getValue(), Json::encode(['action' => $action]));
    }
}
