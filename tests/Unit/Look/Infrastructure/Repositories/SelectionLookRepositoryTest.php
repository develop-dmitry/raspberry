<?php

declare(strict_types=1);

namespace Tests\Unit\Look\Infrastructure\Repositories;

use Illuminate\Support\Facades\Redis;
use Predis\Client;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Tests\TestCase;

class SelectionLookRepositoryTest extends TestCase
{

    protected Client $redis;

    protected function setUp(): void
    {
        parent::setUp();

        $this->redis = Redis::client();
    }

    public function testRestoreData(): void
    {
        $this->redis->set('look_selection:1:temperature', 10);
        $this->redis->set('look_selection:1:event_id', 1);

        $selectionLookRepository = new SelectionLookRepository(1);

        $this->assertEquals(10, $selectionLookRepository->getTemperature());
        $this->assertEquals(1, $selectionLookRepository->getEventId());
    }

    public function testSetTemperature(): void
    {
        $selectionLookRepository = new SelectionLookRepository(1);
        $selectionLookRepository->setTemperature(-20);

        $this->assertEquals(-20, $this->redis->get('look_selection:1:temperature'));
    }

    public function testSetEvent(): void
    {
        $selectionLookRepository = new SelectionLookRepository(1);
        $selectionLookRepository->setEventId(5);

        $this->assertEquals(5, $this->redis->get('look_selection:1:event_id'));
    }
}
