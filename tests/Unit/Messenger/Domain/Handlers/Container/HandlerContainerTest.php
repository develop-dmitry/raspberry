<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Domain\Handlers\Container;

use Raspberry\Messenger\Domain\Base\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Base\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Base\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Base\Handlers\HandlerTypeEnum;
use Tests\TestCase;

class HandlerContainerTest extends TestCase
{
    public function testGetNonExistentHandler(): void
    {
        $handlers = new HandlerContainer();

        $this->expectException(HandlerNotFoundException::class);
        $handlers->getHandler('test', HandlerTypeEnum::Command);
    }

    public function testGetExistentHandler(): void
    {
        $handlers = new HandlerContainer();

        $searching = $this->getMockBuilder(HandlerInterface::class)->getMock();

        $handlers
            ->addHandler('test', HandlerTypeEnum::Command, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test2', HandlerTypeEnum::Message, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test3', HandlerTypeEnum::Message, $searching);

        $this->assertEquals($searching, $handlers->getHandler('test3', HandlerTypeEnum::Message));
    }

    public function testFilterByType(): void
    {
        $handlers = new HandlerContainer();

        $handlers
            ->addHandler('test', HandlerTypeEnum::Command, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test2', HandlerTypeEnum::Message, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test3', HandlerTypeEnum::Message, $this->getMockBuilder(HandlerInterface::class)->getMock());

        $this->assertCount(2, $handlers->filterByType(HandlerTypeEnum::Message));
    }
}
