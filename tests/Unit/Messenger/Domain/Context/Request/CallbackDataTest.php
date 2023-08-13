<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Domain\Context\Request;

use Illuminate\Database\Eloquent\Casts\Json;
use Raspberry\Messenger\Domain\Base\Context\Request\CallbackData\CallbackData;
use Tests\TestCase;

class CallbackDataTest extends TestCase
{
    public function testSearchByQuery(): void
    {
        $query = [
            'action' => 'test',
            'param1' => 'value1',
            'param2' => [
                'subparam1' => 'subvalue1',
                'subparam2' => 'subvalue2'
            ]
        ];

        $callbackData = CallbackData::fromJson(Json::encode($query));

        $this->assertEquals($query['param1'], $callbackData->get('param1'));
        $this->assertEquals($query['param2']['subparam1'], $callbackData->get('param2.subparam1'));
    }

    public function testDefaultSearchQuery(): void
    {
        $callbackData = CallbackData::fromJson(Json::encode([]));

        $this->assertEquals('value', $callbackData->get('test', 'value'));
    }
}
