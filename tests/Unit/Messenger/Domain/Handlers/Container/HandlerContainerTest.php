<?php

declare(strict_types=1);

namespace Tests\Unit\Messenger\Domain\Handlers\Container;

use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\Container\HandlerContainer;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Tests\TestCase;

class HandlerContainerTest extends TestCase
{
    public function testGetNonExistentHandler(): void
    {
        $handlers = new HandlerContainer();

        $this->expectException(HandlerNotFoundException::class);
        $handlers->getHandler('test', HandlerType::Command);
    }

    public function testGetExistentHandler(): void
    {
        $handlers = new HandlerContainer();

        $searching = $this->getMockBuilder(HandlerInterface::class)->getMock();

        $handlers
            ->addHandler('test', HandlerType::Command, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test2', HandlerType::Message, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test3', HandlerType::Message, $searching);

        $this->assertEquals($searching, $handlers->getHandler('test3', HandlerType::Message));
    }

    public function testFilterByType(): void
    {
        $handlers = new HandlerContainer();

        $handlers
            ->addHandler('test', HandlerType::Command, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test2', HandlerType::Message, $this->getMockBuilder(HandlerInterface::class)->getMock())
            ->addHandler('test3', HandlerType::Message, $this->getMockBuilder(HandlerInterface::class)->getMock());

        $this->assertCount(2, $handlers->filterByType(HandlerType::Message));
    }
}
