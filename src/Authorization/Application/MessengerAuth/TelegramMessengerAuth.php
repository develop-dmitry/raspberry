<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerAuth;

use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthRequest;
use Raspberry\Authorization\Application\MessengerAuth\DTO\MessengerAuthResponse;
use Raspberry\Authorization\Domain\User\UserRepositoryInterface;

class TelegramMessengerAuth implements MessengerAuthInterface
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
    public function execute(MessengerAuthRequest $request): MessengerAuthResponse
    {
        $user = $this->userRepository->getUserByTelegram($request->getMessengerId());

        return new MessengerAuthResponse($user->getId()->getValue(), $user->getApiToken()->getValue());
    }
}
