<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\User;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\UserInterface;

class User implements UserInterface
{

    /**
     * @param IdInterface $id
     * @param StyleInterface[] $styles
     */
    public function __construct(
        protected IdInterface $id,
        protected array $styles
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
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @inheritDoc
     */
    public function addStyle(StyleInterface $style): void
    {
        if (!$this->hasStyle($style)) {
            $this->styles[] = $style;
        }
    }

    /**
     * @inheritDoc
     */
    public function removeStyle(StyleInterface $style): void
    {
        if (!$this->hasStyle($style)) {
            return;
        }

        $this->styles = array_filter(
            $this->styles,
            static fn (StyleInterface $item) => $item->getId()->getValue() !== $style->getId()->getValue()
        );
    }

    public function hasStyle(StyleInterface $style): bool
    {
        $isFind = false;

        foreach ($this->styles as $item) {
            $isFind = $isFind || $item->getId()->getValue() === $style->getId()->getValue();
        }

        return $isFind;
    }
}
