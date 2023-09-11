<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Core\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\SelectionLook\DTO\LookData;
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
            new SelectionLookRepository($request->userId),
            $this->getUser($request->userId),
        );

        $looks = $selectionLookService->selection();
        $looks = array_map(static fn (LookInterface $look) => LookData::fromDomain($look), $looks);

        return new SelectionLookResponse(looks: $looks);
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
