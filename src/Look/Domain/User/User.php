<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\User;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\User\UserInterface;

class User implements UserInterface
{

    /**
     * @var StyleInterface[]
     */
    protected array $styles = [];

    /**
     * @param IdInterface $id
     * @param StyleInterface[] $styles
     */
    public function __construct(
        protected IdInterface $id,
        array $styles
    ) {
        $this->setStyles($styles);
    }

    /**
     * @param StyleInterface[] $styles
     * @return void
     */
    protected function setStyles(array $styles): void
    {
        foreach ($styles as $style) {
            $this->styles[$style->getId()->getValue()] = $style;
        }
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
        if (!$this->isAlreadyHaving($style)) {
            $this->styles[$style->getId()->getValue()] = $style;
        }
    }

    /**
     * @inheritDoc
     */
    public function removeStyle(StyleInterface $style): void
    {
        if ($this->isAlreadyHaving($style)) {
            unset($this->styles[$style->getId()->getValue()]);
        }
    }

    /**
     * @param StyleInterface $style
     * @return bool
     */
    protected function isAlreadyHaving(StyleInterface $style): bool
    {
        return isset($this->styles[$style->getId()->getValue()]);
    }
}
