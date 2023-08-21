<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Common\Values\Temperature\TemperatureInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Look\LookInterface;

class Look implements LookInterface
{
    /**
     * @param IdInterface $id
     * @param NameInterface $name
     * @param SlugInterface $slug
     * @param PhotoInterface $photo
     * @param ClothesInterface[] $clothes
     * @param TemperatureInterface $minTemperature
     * @param TemperatureInterface $maxTemperature
     * @param EventInterface[] $events
     */
    public function __construct(
        protected IdInterface $id,
        protected NameInterface $name,
        protected SlugInterface $slug,
        protected PhotoInterface $photo,
        protected array $clothes,
        protected TemperatureInterface $minTemperature,
        protected TemperatureInterface $maxTemperature,
        protected array $events
    ) {
    }

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface
    {
        return $this->name;
    }

    /**
     * @return SlugInterface
     */
    public function getSlug(): SlugInterface
    {
        return $this->slug;
    }

    /**
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface
    {
        return $this->photo;
    }

    /**
     * @return array
     */
    public function getClothes(): array
    {
        return $this->clothes;
    }

    /**
     * @return TemperatureInterface
     */
    public function getMinTemperature(): TemperatureInterface
    {
        return $this->minTemperature;
    }

    /**
     * @return TemperatureInterface
     */
    public function getMaxTemperature(): TemperatureInterface
    {
        return $this->maxTemperature;
    }

    /**
     * @inheritDoc
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
