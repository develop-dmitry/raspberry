<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Clothes as ClothesModel;
use App\Models\Event as EventModel;
use App\Models\Look as LookModel;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
use Raspberry\Common\Values\Photo\Photo;
use Raspberry\Common\Values\Slug\Slug;
use Raspberry\Common\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Clothes\Clothes;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\Event;
use Raspberry\Look\Domain\Event\EventInterface;
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
     * @inheritDoc
     */
    public function findByTemperature(int $minTemperature, int $maxTemperature): array
    {
        $lookModels = LookModel::where('min_temperature', '>=', $minTemperature)
            ->where('max_temperature', '<=', $maxTemperature)
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
            $look->events->map([$this, 'makeEvent'])->toArray()
        );
    }

    /**
     * @param EventModel $event
     * @return EventInterface
     * @throws InvalidValueException
     */
    public function makeEvent(EventModel $event): EventInterface
    {
        return new Event(new Name($event->name), new Slug($event->slug));
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
            new Name($clothes->name)
        );
    }
}
