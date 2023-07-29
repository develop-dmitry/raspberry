<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Clothes;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;

interface ClothesInterface
{
    /**
     * @return IdInterface|null
     */
    public function getId(): ?IdInterface;

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;

    /**
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface;

    /**
     * @return SlugInterface
     */
    public function getSlug(): SlugInterface;
}
