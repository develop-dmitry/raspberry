<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\UserStyles;

use Raspberry\Look\Application\UserStyles\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\UserStyles\DTO\ToggleStyleResponse;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class UserStylesUseCase implements UserStylesInterface
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
        $style = $this->styleRepository->getById($request->getStyleId());
        $user = $this->userRepository->getById($request->getUserId());

        $isExists = $user->hasStyle($style);

        if ($isExists) {
            $user->removeStyle($style);
        } else {
            $user->addStyle($style);
        }

        $this->userRepository->save($user);

        return new ToggleStyleResponse(!$isExists);
    }
}
