<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\Picker;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\Picker\DTO\LookData;
use Raspberry\Look\Application\Picker\DTO\PickerRequest;
use Raspberry\Look\Application\Picker\DTO\PickerResponse;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\Picker\PickerService;
use Raspberry\Look\Domain\Look\Services\Picker\PickerServiceInterface;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\PickerRepository;

class PickerUseCase implements PickerInterface
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
    public function execute(PickerRequest $request): PickerResponse
    {
        $looks = $this->buildPicker($request->userId)->pick();
        $looks = array_map(static fn (LookInterface $look) => LookData::fromDomain($look), $looks);

        return new PickerResponse(looks: $looks);
    }

    /**
     * @param int $userId
     * @return PickerServiceInterface
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    protected function buildPicker(int $userId): PickerServiceInterface
    {
        $pickerRepository = new PickerRepository($userId);
        $user = $this->userRepository->getById($userId);

        return new PickerService($this->lookRepository, $pickerRepository, $user);
    }
}
