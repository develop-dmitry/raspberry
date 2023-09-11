<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Repositories;

use App\Models\User;
use App\Models\Clothes as ClothesModel;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Wardrobe\Domain\Clothes\Clothes;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainer;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainerInterface;
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

    public function getWardrobeOffers(
        WardrobeInterface $wardrobe,
        int $page,
        int $count
    ): WardrobeOffersContainerInterface {
        $wardrobeClothes = [];

        foreach ($wardrobe->getClothes() as $clothes) {
            $wardrobeClothes[] = $clothes->getId()->getValue();
        }

        $clothesPaginate = ClothesModel::whereNotIn('id', $wardrobeClothes)
            ->paginate($count, page: $page);

        $clothes = [];

        foreach ($clothesPaginate->items() as $item) {
            try {
                $clothes[] = new Clothes(
                    new Id($item->id),
                    new Name($item->name),
                    new Slug($item->slug),
                    new Photo($item->photo)
                );
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid clothes in database', [
                    'clothes' => $item->toArray(),
                    'exception' => $exception->getMessage()
                ]);
            }
        }

        return new WardrobeOffersContainer(
            $clothes,
            $clothesPaginate->currentPage(),
            $count,
            $clothesPaginate->total()
        );
    }
}
