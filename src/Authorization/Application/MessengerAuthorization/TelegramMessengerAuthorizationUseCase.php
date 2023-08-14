<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuthorization;

use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationRequest;
use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationResponse;
use Raspberry\Authorization\Domain\User\UserRepositoryInterface;

class TelegramMessengerAuthorizationUseCase implements MessengerAuthorizationInterface
{

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(MessengerAuthorizationRequest $request): MessengerAuthorizationResponse
    {
        $user = $this->userRepository->getUserByTelegram($request->getMessengerId());

        return new MessengerAuthorizationResponse($user->getId()->getValue());
    }
}
