<?php

namespace Raspberry\Messenger\Application\LookBot\Wardrobe;

use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\WebAppOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;
use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorRequest;
use Raspberry\Wardrobe\Application\UrlGenerator\UrlGeneratorInterface;

class WardrobeHandler extends AbstractHandler
{

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected UrlGeneratorInterface $urlGenerator,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    public function isNeedAuthorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $messenger->sendMessage(Message::withReplyKeyboard('Ваш гардероб', $this->makeKeyboard()));
    }

    /**
     * @return ReplyKeyboardInterface
     */
    protected function makeKeyboard(): ReplyKeyboardInterface
    {
        return $this->replyKeyboardFactory
            ->setResize(new ResizeOption(true))
            ->make()
            ->addRow($this->makeWebAppButton(WardrobeMenu::ShowWardrobe->getText(), $this->getWardrobeUrl()))
            ->addRow($this->makeWebAppButton(WardrobeMenu::WardrobeOffers->getText(), $this->getWardrobeOffersUrl()))
            ->addRow($this->makeTextButton(WardrobeMenu::Back->getText()));
    }

    /**
     * @param string $text
     * @param string $url
     * @return ReplyButtonInterface
     */
    protected function makeWebAppButton(string $text, string $url): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->setWebApp(new WebAppOption($url))
            ->make();
    }

    /**
     * @param string $text
     * @return ReplyButtonInterface
     */
    protected function makeTextButton(string $text): ReplyButtonInterface
    {
        return $this->replyButtonFactory
            ->setText($text)
            ->make();
    }

    /**
     * @return string
     */
    protected function getWardrobeUrl(): string
    {
        $request = new UrlGeneratorRequest(['api_token' => $this->contextUser->getApiToken()->getValue()]);

        return $this->urlGenerator->getWardrobeUrl($request)->getUrl();
    }

    /**
     * @return string
     */
    protected function getWardrobeOffersUrl(): string
    {
        $request = new UrlGeneratorRequest(['api_token' => $this->contextUser->getApiToken()->getValue()]);

        return $this->urlGenerator->getWardrobeOffersUrl($request)->getUrl();
    }
}
