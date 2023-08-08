<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Clothes as ClothesModel;
use App\Models\Look as LookModel;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Photo\Photo;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Look\Domain\Clothes\Clothes;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Look;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;

class LookRepository implements LookRepositoryInterface
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): LookInterface
    {
        $look = LookModel::find($id);

        if (!$look) {
            throw new LookNotFoundException();
        }

        try {
            return $this->makeLook($look);
        } catch (InvalidValueException $exception) {
            $this->logger->error('Invalid look in database', [
                'exception' => $exception->getMessage(),
                'look' => $look->toArray()
            ]);

            throw new LookNotFoundException($exception->getMessage());
        }
    }

    /**
     * @param LookModel $look
     * @return LookInterface
     * @throws InvalidValueException
     */
    protected function makeLook(LookModel $look): LookInterface
    {
        $clothes = [];

        foreach ($look->clothes as $item) {
            try {
                $clothes[] = $this->makeClothes($item);
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid clothes in database', [
                    'exception' => $exception->getMessage(),
                    'clothes' => $item->toArray()
                ]);
            }
        }

        return new Look(
            new Id($look->id),
            new Name($look->name),
            new Slug($look->slug),
            new Photo($look->photo),
            $clothes
        );
    }

    /**
     * @param ClothesModel $clothes
     * @return ClothesInterface
     * @throws InvalidValueException
     */
    protected function makeClothes(ClothesModel $clothes): ClothesInterface
    {
        return new Clothes(new Photo($clothes->photo));
    }
}
