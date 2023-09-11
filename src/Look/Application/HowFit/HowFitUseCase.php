<?php

namespace Raspberry\Look\Application\HowFit;

use Raspberry\Look\Application\HowFit\DTO\HowFitRequest;
use Raspberry\Look\Application\HowFit\DTO\HowFitResponse;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class HowFitUseCase implements HowFitInterface
{

    public function __construct(
        protected LookRepositoryInterface $lookRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(HowFitRequest $request): HowFitResponse
    {
        $look = $this->lookRepository->getById($request->lookId);
        $user = $this->userRepository->getById($request->userId);
        $percent = $look->howFit($user);

        return new HowFitResponse(percent: $percent->getValue());
    }
}
