<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\Factory;

use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButton;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\Options\NullOption;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class ReplyButtonFactory implements ReplyButtonFactoryInterface
{
    protected string $text;

    protected ?OptionInterface $sendLocation;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * @inheritDoc
     */
    public function setText(string $text): ReplyButtonFactoryInterface
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSendLocation(OptionInterface $sendLocation): ReplyButtonFactoryInterface
    {
        $this->sendLocation = $sendLocation;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function make(): ReplyButtonInterface
    {
        $button = new ReplyButton($this->getText(), $this->getSendLocation());

        $this->reset();

        return $button;
    }

    protected function getText(): string
    {
        return $this->text ?: 'Без названия';
    }

    protected function getSendLocation(): OptionInterface
    {
        return $this->sendLocation ?: new NullOption();
    }

    protected function reset(): void
    {
        $this->text = '';
        $this->sendLocation = null;
    }
}
