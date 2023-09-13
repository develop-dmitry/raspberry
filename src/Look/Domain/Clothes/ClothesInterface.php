<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Clothes;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Name\NameInterface;
use Raspberry\Core\Values\Photo\PhotoInterface;
use Raspberry\Look\Domain\Style\StyleInterface;

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

    /**
     * @return StyleInterface[]
     */
    public function getStyles(): array;
}
