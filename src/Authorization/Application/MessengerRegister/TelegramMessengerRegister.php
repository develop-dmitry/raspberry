<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Application\MessengerRegister;

use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterRequest;
use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterResponse;
use Raspberry\Authorization\Domain\User\User;
use Raspberry\Authorization\Domain\User\UserInterface;
use Raspberry\Authorization\Domain\User\UserRepositoryInterface;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;

class TelegramMessengerRegister implements MessengerRegisterInterface
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
    public function execute(MessengerRegisterRequest $request): MessengerRegisterResponse
    {
        $user = $this->createUser($request->getMessengerId());

        return new MessengerRegisterResponse($user->getId()->getValue(), $user->getApiToken()->getValue());
    }

    /**
     * @param int $messengerId
     * @return UserInterface
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    protected function createUser(int $messengerId): UserInterface
    {
        $user = User::register(new Id($messengerId));

        return $this->userRepository->createUser($user);
    }
}
