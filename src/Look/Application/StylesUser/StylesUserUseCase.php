<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser;

use Raspberry\Core\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleResponse;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class StylesUserUseCase implements StylesUserInterface
{

    /**
     * @param StyleRepositoryInterface $styleRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected StyleRepositoryInterface $styleRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function toggleStyle(ToggleStyleRequest $request): void
    {
        $style = $this->getStyle($request->styleId);
        $user = $this->getUser($request->userId);

        $isExists = $user->hasStyle($style);

        if ($isExists) {
            $user->removeStyle($style);
        } else {
            $user->addStyle($style);
        }

        $this->userRepository->save($user);
    }

    /**
     * @inheritDoc
     */
    public function hasStyle(HasStyleRequest $request): HasStyleResponse
    {
        $user = $this->getUser($request->userId);
        $style = $this->getStyle($request->styleId);

        return new HasStyleResponse(hasStyle: $user->hasStyle($style));
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
