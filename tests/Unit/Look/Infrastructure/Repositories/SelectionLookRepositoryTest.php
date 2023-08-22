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
        $this->redis->set('look_selection:1:min_temperature', -10);
        $this->redis->set('look_selection:1:max_temperature', 10);
        $this->redis->set('look_selection:1:event_id', 1);

        $selectionLookRepository = new SelectionLookRepository(app(EventRepositoryInterface::class));
        $selectionLookRepository->wake(1);

        $this->assertEquals(-10, $selectionLookRepository->getMinTemperature());
        $this->assertEquals(10, $selectionLookRepository->getMaxTemperature());
        $this->assertEquals(1, $selectionLookRepository->getEventId());
    }

    public function testSetMinTemperature(): void
    {
        $selectionLookRepository = new SelectionLookRepository(app(EventRepositoryInterface::class));
        $selectionLookRepository->wake(1);
        $selectionLookRepository->setMinTemperature(-20);

        $this->assertEquals(-20, $this->redis->get('look_selection:1:min_temperature'));
    }

    public function testSetMaxTemperature(): void
    {
        $selectionLookRepository = new SelectionLookRepository(app(EventRepositoryInterface::class));
        $selectionLookRepository->wake(1);
        $selectionLookRepository->setMaxTemperature(20);

        $this->assertEquals(20, $this->redis->get('look_selection:1:max_temperature'));
    }

    public function testSetEvent(): void
    {
        $selectionLookRepository = new SelectionLookRepository(app(EventRepositoryInterface::class));
        $selectionLookRepository->wake(1);
        $selectionLookRepository->setEventId(5);

        $this->assertEquals(5, $this->redis->get('look_selection:1:event_id'));
    }
}
