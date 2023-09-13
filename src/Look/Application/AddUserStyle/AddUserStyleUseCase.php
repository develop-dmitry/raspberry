<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\AddUserStyle;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\AddUserStyle\AddUserStyleInterface;
use Raspberry\Look\Application\AddUserStyle\DTO\AddUserStyleRequest;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class AddUserStyleUseCase implements AddUserStyleInterface
{

    /**
     * @param UserRepositoryInterface $userRepository
     * @param StyleRepositoryInterface $styleRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected StyleRepositoryInterface $styleRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(AddUserStyleRequest $request): void
    {
        $user = $this->getUser($request->userId);
        $style = $this->getStyle($request->styleId);

        $user->addStyle($style);

        $this->userRepository->save($user);
    }

    /**
     * @param int $userId
     * @return UserInterface
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    protected function getUser(int $userId): UserInterface
    {
        return $this->userRepository->getById($userId);
    }

    /**
     * @param int $styleId
     * @return StyleInterface
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     */
    protected function getStyle(int $styleId): StyleInterface
    {
        return $this->styleRepository->getById($styleId);
    }
}
