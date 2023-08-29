<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\SelectionLook\DTO\LookItem;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookResponse;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookService;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;

class SelectionLookUseCase implements SelectionLookInterface
{

    /**
     * @param LookRepositoryInterface $lookRepository
     * @param EventRepositoryInterface $eventRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected EventRepositoryInterface $eventRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(SelectionLookRequest $request): SelectionLookResponse
    {

        $selectionLookService = new SelectionLookService(
            $this->lookRepository,
            new SelectionLookRepository($request->getUserId()),
            $this->getUser($request->getUserId()),
        );

        $looks = array_map([$this, 'makeLookItem'], $selectionLookService->selection());

        return new SelectionLookResponse($looks);
    }

    /**
     * @param LookInterface $look
     * @return LookItem
     */
    protected function makeLookItem(LookInterface $look): LookItem
    {
        return new LookItem(
            $look->getId()->getValue(),
            $look->getName()->getValue(),
            $look->getPhoto()->getValue()
        );
    }

    /**
     * @param int $userId
     * @return UserInterface
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    protected function getUser(int $userId): UserInterface
    {
        return $this->userRepository->getById($userId);
    }
}
