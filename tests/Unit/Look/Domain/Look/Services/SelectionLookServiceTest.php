<?php

namespace Tests\Unit\Look\Domain\Look\Services;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Clothes\Clothes;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\Event;
use Raspberry\Look\Domain\Look\Look;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookService;
use Raspberry\Look\Domain\Style\Style;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\User;
use Tests\TestCase;

class SelectionLookServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testSelectionLook(): void
    {
        $event = new Event(new Id(1), new Name('test'), new Slug('test'));

        $styles = [$this->makeStyle(1), $this->makeStyle(2), $this->makeStyle(3)];

        $clothes = [
            $this->makeClothes(1, [$styles[0], $styles[1]]),
            $this->makeClothes(2, [$styles[0]]),
            $this->makeClothes(3, [$styles[1], $styles[2]])
        ];

        $user = new User(new Id(1), [$styles[1], $styles[2]]);

        $looks = [
            $this->makeLook(1, [$clothes[0], $clothes[1]], [$event]),
            $this->makeLook(2, [$clothes[1]], [$event]),
            $this->makeLook(3, [$clothes[0], $clothes[2]], [$event]),
        ];

        $selectionLookService = new SelectionLookService(
            $this->makeLookRepository($looks),
            $this->makeSelectionLookRepository(1, -2),
            $user
        );

        $selectionLooks = $selectionLookService->selection();

        $this->assertEquals(3, $selectionLooks[0]->getId()->getValue());
        $this->assertEquals(1, $selectionLooks[1]->getId()->getValue());
        $this->assertEquals(2, $selectionLooks[2]->getId()->getValue());
    }

    protected function makeStyle(int $id): StyleInterface
    {
        return new Style(new Id($id), new Name('test'));
    }

    protected function makeClothes(int $id, array $styles): ClothesInterface
    {
        return new Clothes(new Id($id), new Photo('/test.png'), new Name('test'), $styles);
    }

    protected function makeLook(int $id, array $clothes, array $events): LookInterface
    {
        return new Look(
            new Id($id),
            new Name('test'),
            new Slug('test'),
            new Photo('test'),
            $clothes,
            new Temperature(-5),
            new Temperature(0),
            $events
        );
    }

    protected function makeLookRepository(array $looks): LookRepositoryInterface
    {
        $lookRepository = $this->createMock(LookRepositoryInterface::class);
        $lookRepository->method('findForSelection')->willReturn($looks);

        return $lookRepository;
    }

    protected function makeSelectionLookRepository(int $eventId, int $temperature): SelectionLookRepositoryInterface
    {
        $selectionLookRepository = $this->createMock(SelectionLookRepositoryInterface::class);
        $selectionLookRepository->method('getEventId')->willReturn($eventId);
        $selectionLookRepository->method('getTemperature')->willReturn($temperature);

        return $selectionLookRepository;
    }
}
