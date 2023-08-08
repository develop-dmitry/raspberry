<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;
use Raspberry\Look\Domain\Look\LookInterface;

class Look implements LookInterface
{
    /**
     * @param IdInterface $id
     * @param NameInterface $name
     * @param SlugInterface $slug
     * @param PhotoInterface $photo
     * @param ClothesInterface[] $clothes
     */
    public function __construct(
        protected IdInterface $id,
        protected NameInterface $name,
        protected SlugInterface $slug,
        protected PhotoInterface $photo,
        protected array $clothes
    ) {
    }

    public function getId(): IdInterface
    {
        return $this->id;
    }

    public function getName(): NameInterface
    {
        return $this->name;
    }

    public function getSlug(): SlugInterface
    {
        return $this->slug;
    }

    public function getPhoto(): PhotoInterface
    {
        return $this->photo;
    }

    public function getClothes(): array
    {
        return $this->clothes;
    }
}
