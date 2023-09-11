<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Repositories;

use App\Models\Clothes as ClothesModel;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Wardrobe\Domain\Clothes\Clothes;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;

class ClothesRepository implements \Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getClothesById(int $clothesId): ClothesInterface
    {
        $clothes = ClothesModel::find($clothesId);

        if (!$clothes) {
            throw new ClothesNotFoundException();
        }

        try {
            return new Clothes(
                new Id($clothes->id),
                new Name($clothes->name),
                new Slug($clothes->slug),
                new Photo($clothes->photo)
            );
        } catch (InvalidValueException $exception) {
            $this->logger->error('Invalid clothes in database', [
                'exception' => $exception->getMessage(),
                'clothes' => $clothes->toArray()
            ]);

            throw new ClothesNotFoundException();
        }
    }
}
