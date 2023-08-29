<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Percent\PercentInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Common\Values\Temperature\TemperatureInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\UserInterface;

interface LookInterface
{
    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;

    /**
     * @return SlugInterface
     */
    public function getSlug(): SlugInterface;

    /**
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface;

    /**
     * @return ClothesInterface[]
     */
    public function getClothes(): array;

    /**
     * @return TemperatureInterface
     */
    public function getMinTemperature(): TemperatureInterface;

    /**
     * @return TemperatureInterface
     */
    public function getMaxTemperature(): TemperatureInterface;

    /**
     * @return EventInterface[]
     */
    public function getEvents(): array;

    /**
     * @return StyleInterface[]
     */
    public function getStyles(): array;

    /**
     * @param UserInterface $user
     * @return PercentInterface
     * @throws InvalidValueException
     */
    public function howFit(UserInterface $user): PercentInterface;
}
