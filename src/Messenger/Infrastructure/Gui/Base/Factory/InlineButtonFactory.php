<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Infrastructure\Gui\Base\Factory;

use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButton;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Options\NullOption;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

class InlineButtonFactory implements InlineButtonFactoryInterface
{
    protected string $text;

    protected ?OptionInterface $callbackData;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * @inheritDoc
     */
    public function setText(string $text): InlineButtonFactoryInterface
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCallbackData(OptionInterface $callbackData): InlineButtonFactoryInterface
    {
        $this->callbackData = $callbackData;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function make(): InlineButtonInterface
    {
        $button = new InlineButton($this->getText(), $this->getCallbackData());

        $this->reset();

        return $button;
    }

    protected function getText(): string
    {
        return $this->text ?: 'Без названия';
    }

    protected function getCallbackData(): OptionInterface
    {
        return $this->callbackData ?: new NullOption();
    }

    protected function reset(): void
    {
        $this->text = '';
        $this->callbackData = null;
    }
}
