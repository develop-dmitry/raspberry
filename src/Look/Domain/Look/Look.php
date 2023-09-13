<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Name\NameInterface;
use Raspberry\Core\Values\Percent\Percent;
use Raspberry\Core\Values\Percent\PercentInterface;
use Raspberry\Core\Values\Photo\PhotoInterface;
use Raspberry\Core\Values\Slug\SlugInterface;
use Raspberry\Core\Values\Temperature\TemperatureInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\UserInterface;

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

    /**
     * @inheritDoc
     */
    public function getStyles(): array
    {
        $allStyles = array_map(static fn (ClothesInterface $clothes) => $clothes->getStyles(), $this->clothes);
        $allStyles = array_reduce($allStyles, 'array_merge', []);

        $styles = [];

        foreach ($allStyles as $style) {
            $styles[$style->getId()->getValue()] = $style;
        }

        return $styles;
    }

    /**
     * @inheritDoc
     */
    public function pickerScore(UserInterface $user): PercentInterface
    {
        $lookStyles = array_map(static fn (StyleInterface $style) => $style->getId()->getValue(), $this->getStyles());
        $userStyles = array_map(static fn (StyleInterface $style) => $style->getId()->getValue(), $user->getStyles());

        if (empty($lookStyles) || empty($userStyles)) {
            return Percent::max();
        }

        $intersect = array_intersect($lookStyles, $userStyles);

        return Percent::fromDecimal(count($intersect) / count($lookStyles));
    }
}
