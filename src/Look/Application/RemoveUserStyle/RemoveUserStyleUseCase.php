<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\RemoveUserStyle;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\RemoveUserStyle\DTO\RemoveUserStyleRequest;
use Raspberry\Look\Application\RemoveUserStyle\RemoveUserStyleInterface;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class RemoveUserStyleUseCase implements RemoveUserStyleInterface
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
    public function execute(RemoveUserStyleRequest $request): void
    {
        $user = $this->getUser($request->userId);
        $style = $this->getStyle($request->styleId);

        $user->removeStyle($style);

        $this->userRepository->save($user);
    }

    /**
     * @param int $id
     * @return UserInterface
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    protected function getUser(int $id): UserInterface
    {
        return $this->userRepository->getById($id);
    }

    /**
     * @param int $id
     * @return StyleInterface
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     */
    protected function getStyle(int $id): StyleInterface
    {
        return $this->styleRepository->getById($id);
    }
}
