<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;

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
}
