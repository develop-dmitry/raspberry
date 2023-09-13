<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Clothes;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Name\NameInterface;
use Raspberry\Core\Values\Photo\PhotoInterface;
use Raspberry\Core\Values\Slug\SlugInterface;

interface ClothesInterface
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
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface;

    /**
     * @return SlugInterface
     */
    public function getSlug(): SlugInterface;
}
