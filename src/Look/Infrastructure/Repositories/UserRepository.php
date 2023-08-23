<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\User;
use Raspberry\Look\Domain\User\UserInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @param StyleRepositoryInterface $styleRepository
     */
    public function __construct(
        protected StyleRepositoryInterface $styleRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): UserInterface
    {
        $user = UserModel::find($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $this->makeUser($user);
    }

    /**
     * @inheritDoc
     */
    public function save(UserInterface $user): void
    {
        $model = UserModel::find($user->getId()->getValue());

        if (!$model) {
            throw new UserNotFoundException();
        }

        DB::transaction(static function () use ($user, $model) {
            $styles = array_map(static fn (StyleInterface $style) => $style->getId()->getValue(), $user->getStyles());

            $model->styles()->sync($styles);
        });
    }

    /**
     * @param UserModel $user
     * @return UserInterface
     * @throws InvalidValueException
     */
    protected function makeUser(UserModel $user): UserInterface
    {
        return new User(
            new Id($user->id),
            $this->styleRepository->getCollection($user->styles()->pluck('id')->toArray())
        );
    }
}
