<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Clothes;

use Raspberry\Common\Values\Photo\PhotoInterface;

interface ClothesInterface
{
    /**
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface;
}
