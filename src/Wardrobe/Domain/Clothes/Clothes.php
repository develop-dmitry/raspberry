<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Domain\Clothes;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;

class Clothes implements ClothesInterface
{
    public function __construct(
        protected IdInterface $id,
        protected NameInterface $name,
        protected SlugInterface $slug,
        protected PhotoInterface $photo
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): NameInterface
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getSlug(): SlugInterface
    {
        return $this->slug;
    }

    /**
     * @inheritDoc
     */
    public function getPhoto(): PhotoInterface
    {
        return $this->photo;
    }
}
