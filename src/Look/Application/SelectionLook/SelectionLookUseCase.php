<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Look\Application\SelectionLook\DTO\LookItem;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookResponse;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookService;

class SelectionLookUseCase implements SelectionLookInterface
{

    /**
     * @param LookRepositoryInterface $lookRepository
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected EventRepositoryInterface $eventRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(SelectionLookRequest $request): SelectionLookResponse
    {
        $selectionLookService = new SelectionLookService(
            $this->lookRepository,
            $request->getUserId()
        );

        $looks = array_map([$this, 'makeLookItem'], $selectionLookService->selection());

        return new SelectionLookResponse($looks);
    }

    protected function makeLookItem(LookInterface $look): LookItem
    {
        return new LookItem(
            $look->getId()->getValue(),
            $look->getName()->getValue(),
            $look->getPhoto()->getValue()
        );
    }
}
