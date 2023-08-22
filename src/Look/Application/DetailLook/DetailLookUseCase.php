<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook;

use Raspberry\Look\Application\DetailLook\DTO\ClothesItem;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookResponse;
use Raspberry\Look\Application\DetailLook\DTO\EventItem;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;

class DetailLookUseCase implements DetailLookInterface
{
    public function __construct(
        protected LookRepositoryInterface $lookRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(DetailLookRequest $request): DetailLookResponse
    {
        $look = $this->lookRepository->getById($request->getId());

        return $this->makeResponse($look);
    }

    /**
     * @param LookInterface $look
     * @return DetailLookResponse
     */
    protected function makeResponse(LookInterface $look): DetailLookResponse
    {
        return new DetailLookResponse(
            $look->getId()->getValue(),
            $look->getName()->getValue(),
            $look->getSlug()->getValue(),
            $look->getPhoto()->getValue(),
            $this->makeClothes($look->getClothes()),
            $this->makeEvents($look->getEvents())
        );
    }

    /**
     * @param ClothesInterface[] $items
     * @return ClothesItem[]
     */
    protected function makeClothes(array $items): array
    {
        $clothes = [];

        foreach ($items as $item) {
            $clothes[] = new ClothesItem(
                $item->getId()->getValue(),
                $item->getPhoto()->getValue(),
                $item->getName()->getValue()
            );
        }

        return $clothes;
    }

    /**
     * @param EventInterface[] $items
     * @return EventItem[]
     */
    protected function makeEvents(array $items): array
    {
        $events = [];

        foreach ($items as $item) {
            $events[] = new EventItem($item->getName()->getValue());
        }

        return $events;
    }
}
