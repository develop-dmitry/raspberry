<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Gui\Factory;

use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;

interface InlineButtonFactoryInterface
{
    /**
     * @param string $text
     * @return self
     */
    public function setText(string $text): self;

    /**
     * @param OptionInterface $callbackData
     * @return self
     */
    public function setCallbackData(OptionInterface $callbackData): self;

    /**
     * @param OptionInterface $webApp
     * @return self
     */
    public function setWebApp(OptionInterface $webApp): self;

    /**
     * @param OptionInterface $url
     * @return self
     */
    public function setUrl(OptionInterface $url): self;

    /**
     * @return InlineButtonInterface
     */
    public function make(): InlineButtonInterface;
}
