<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Clothes;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Photo\PhotoInterface;

interface ClothesInterface
{
    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface;

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;
}
