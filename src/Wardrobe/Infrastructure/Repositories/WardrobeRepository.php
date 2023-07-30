<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Repositories;

use App\Models\User;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Photo\Photo;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Wardrobe\Domain\Clothes\Clothes;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Wardrobe;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeRepository implements WardrobeRepositoryInterface
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getWardrobe(int $userId): WardrobeInterface
    {
        $user = User::find($userId);

        if (!$user) {
            throw new UserDoesNotExistsException();
        }

        $clothes = [];

        foreach ($user->clothes as $item) {
            try {
                $clothes[] = new Clothes(
                    new Id($item->id),
                    new Name($item->name),
                    new Slug($item->slug),
                    new Photo($item->photo)
                );
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid clothes in database', [
                    'exception' => $exception->getMessage(),
                    'clothes' => $item->toArray()
                ]);
            }
        }

        try {
            return new Wardrobe(new Id($userId), $clothes);
        } catch (InvalidValueException $exception) {
            throw new UserDoesNotExistsException();
        }
    }

    public function saveWardrobe(WardrobeInterface $wardrobe): void
    {
        $user = User::find($wardrobe->getUserId()->getValue());

        if (!$user) {
            throw new UserDoesNotExistsException();
        }

        $clothes = [];

        foreach ($wardrobe->getClothes() as $item) {
            $clothes[] = $item->getId()->getValue();
        }

        $user->clothes()->sync($clothes);
    }
}
