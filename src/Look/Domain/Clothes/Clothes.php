<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Clothes;

use Raspberry\Common\Values\Photo\PhotoInterface;
use Raspberry\Look\Domain\Clothes\ClothesInterface;

class Clothes implements ClothesInterface
{
    public function __construct(
        protected PhotoInterface $photo
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPhoto(): PhotoInterface
    {
        return $this->photo;
    }
}
