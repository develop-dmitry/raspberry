<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Clothes;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Look\Domain\Style\StyleInterface;

class Clothes implements ClothesInterface
{

    /**
     * @param IdInterface $id
     * @param PhotoInterface $photo
     * @param NameInterface $name
     * @param StyleInterface[] $styles
     */
    public function __construct(
        protected IdInterface $id,
        protected PhotoInterface $photo,
        protected NameInterface $name,
        protected array $styles
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPhoto(): PhotoInterface
    {
        return $this->photo;
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
     * @return StyleInterface[]
     */
    public function getStyles(): array
    {
        return $this->styles;
    }
}
