<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Percent\Percent;
use Raspberry\Common\Values\Percent\PercentInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Common\Values\Temperature\TemperatureInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventInterface;
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
        $allStyles = array_map(fn(ClothesInterface $clothes) => $clothes->getStyles(), $this->clothes);
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
    public function howFit(UserInterface $user): PercentInterface
    {
        $styles = $this->getStyles();
        $userStyles = array_map(fn ($style) => $style->getId()->getValue(), $user->getStyles());

        if (empty($styles) || empty($userStyles)) {
            return Percent::max();
        }

        $fitStyles = array_filter($styles, fn ($style) => in_array($style->getId()->getValue(), $userStyles));

        return Percent::fromDecimal(count($fitStyles) / count($styles));
    }
}
