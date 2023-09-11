<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook;

use Raspberry\Look\Application\DetailLook\DTO\ClothesData;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookResponse;
use Raspberry\Look\Application\DetailLook\DTO\EventData;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
        $look = $this->lookRepository->getById($request->id);

        $clothes = $look->getClothes();
        $events = $look->getEvents();

        return new DetailLookResponse(
            id: $look->getId()->getValue(),
            name: $look->getName()->getValue(),
            slug: $look->getSlug()->getValue(),
            photo: $look->getPhoto()->getValue(),
            clothes: array_map(static fn (ClothesInterface $clothes) => ClothesData::fromDomain($clothes), $clothes),
            events: array_map(static fn (EventInterface $event) => EventData::fromDomain($event), $events),
        );
    }
}
