<?php

namespace Raspberry\Look\Application\PickerScore;

use Raspberry\Look\Application\PickerScore\DTO\PickerScoreRequest;
use Raspberry\Look\Application\PickerScore\DTO\PickerScoreResponse;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class PickerScoreUseCase implements PickerScoreInterface
{

    /**
     * @param LookRepositoryInterface $lookRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(PickerScoreRequest $request): PickerScoreResponse
    {
        $look = $this->lookRepository->getById($request->lookId);
        $user = $this->userRepository->getById($request->userId);
        $percent = $look->pickerScore($user);

        return new PickerScoreResponse(percent: $percent->getValue());
    }
}
