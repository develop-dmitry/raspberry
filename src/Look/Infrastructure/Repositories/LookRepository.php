<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Clothes as ClothesModel;
use App\Models\Look as LookModel;
use Illuminate\Database\Eloquent\Builder;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Core\Values\Photo\Photo;
use Raspberry\Core\Values\Slug\Slug;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Clothes\Clothes;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Look;
use Raspberry\Look\Domain\Look\LookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;

class LookRepository implements LookRepositoryInterface
{
    public function __construct(
        protected EventRepositoryInterface $eventRepository,
        protected StyleRepositoryInterface $styleRepository,
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
     * @param int $minTemperature
     * @param int $maxTemperature
     * @param int $eventId
     * @inheritDoc
     */
    public function findForSelection(int $minTemperature, int $maxTemperature, int $eventId): array
    {
        $lookModels = LookModel::where('min_temperature', '>=', $minTemperature)
            ->where('max_temperature', '<=', $maxTemperature)
            ->whereHas('events', fn (Builder $builder) => $builder->where('id', $eventId))
            ->get();

        $looks = [];

        foreach ($lookModels as $lookModel) {
            try {
                $looks[] = $this->makeLook($lookModel);
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid look in database', [
                    'exception' => $exception->getMessage(),
                    'look' => $lookModel->toArray()
                ]);
            }
        }

        return $looks;
    }

    /**
     * @param LookModel $look
     * @return LookInterface
     * @throws InvalidValueException
     */
    protected function makeLook(LookModel $look): LookInterface
    {
        return new Look(
            new Id($look->id),
            new Name($look->name),
            new Slug($look->slug),
            new Photo($look->photo),
            $look->clothes->map([$this, 'makeClothes'])->toArray(),
            new Temperature($look->min_temperature),
            new Temperature($look->max_temperature),
            $this->eventRepository->getCollection($look->events()->pluck('id')->toArray())
        );
    }

    /**
     * @param ClothesModel $clothes
     * @return ClothesInterface
     * @throws InvalidValueException
     */
    public function makeClothes(ClothesModel $clothes): ClothesInterface
    {
        return new Clothes(
            new Id($clothes->id),
            new Photo($clothes->photo),
            new Name($clothes->name),
            $this->styleRepository->getCollection($clothes->styles()->pluck('id')->toArray())
        );
    }
}
