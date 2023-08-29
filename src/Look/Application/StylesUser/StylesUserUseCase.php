<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\StylesUser;

use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleResponse;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleResponse;
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
    public function toggleStyle(ToggleStyleRequest $request): ToggleStyleResponse
    {
        $style = $this->getStyle($request->getStyleId());
        $user = $this->getUser($request->getUserId());

        $isExists = $user->hasStyle($style);

        if ($isExists) {
            $user->removeStyle($style);
        } else {
            $user->addStyle($style);
        }

        $this->userRepository->save($user);

        return new ToggleStyleResponse(!$isExists);
    }

    /**
     * @inheritDoc
     */
    public function hasStyle(HasStyleRequest $request): HasStyleResponse
    {
        $user = $this->getUser($request->getUserId());
        $style = $this->getStyle($request->getStyleId());

        return new HasStyleResponse($user->hasStyle($style));
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
