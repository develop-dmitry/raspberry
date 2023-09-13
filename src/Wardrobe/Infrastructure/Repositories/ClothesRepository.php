<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Repositories;

use App\Models\Clothes as ClothesModel;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Pagination\Pagination;
use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Wardrobe\Domain\Clothes\Clothes;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface;

class ClothesRepository implements ClothesRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getById(int $clothesId): ClothesInterface
    {
        $clothes = ClothesModel::find($clothesId);

        if (!$clothes) {
            throw new ClothesNotFoundException();
        }

        return$this->makeClothes($clothes);
    }

    /**
     * @inheritDoc
     */
    public function whereNotIn(array $exclude, int $page, int $count): PaginationInterface
    {
        $pagination = ClothesModel::whereNotIn('id', $exclude)->paginate($count, page: $page);
        $exclude = $pagination->map(fn (ClothesModel $clothes) => $this->makeClothes($clothes))->toArray();

        return new Pagination(
            $exclude,
            $pagination->total(),
            $pagination->currentPage(),
            $pagination->perPage()
        );
    }

    /**
     * @param ClothesModel $model
     * @return ClothesInterface
     * @throws InvalidValueException
     */
    protected function makeClothes(ClothesModel $model): ClothesInterface
    {
        return new Clothes(
            new Id($model->id),
            new Name($model->name),
            new Slug($model->slug),
            new Photo($model->photo)
        );
    }
}
