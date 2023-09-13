<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\UserStyles;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\UserStyles\DTO\UserStylesRequest;
use Raspberry\Look\Application\UserStyles\DTO\UserStylesResponse;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class UserStylesUseCase implements UserStylesInterface
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
    public function execute(UserStylesRequest $request): UserStylesResponse
    {
        $styles = $this->getUserStyles($request->userId);

        return new UserStylesResponse(styles: $styles);
    }

    /**
     * @param int $userId
     * @return int[]
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    protected function getUserStyles(int $userId): array
    {
        $user = $this->getUser($userId);

        return array_map(static fn (StyleInterface $style) => $style->getId()->getValue(), $user->getStyles());
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
}
