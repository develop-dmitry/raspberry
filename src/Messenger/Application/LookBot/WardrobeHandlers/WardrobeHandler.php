<?php

namespace Raspberry\Messenger\Application\LookBot\WardrobeHandlers;

use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Application\LookBot\Enums\WardrobeMenu;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\ReplyButton\ReplyButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\ReplyKeyboard\ReplyKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\WebAppOption;
use Raspberry\Messenger\Domain\Gui\Options\ReplyKeyboard\ResizeOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Wardrobe\Application\UrlGenerator\DTO\UrlGeneratorRequest;
use Raspberry\Wardrobe\Application\UrlGenerator\UrlGeneratorInterface;

class WardrobeHandler extends AbstractHandler
{
    use AuthorizeTrait;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param MessengerAuthorizationInterface $messengerAuthorization
     * @param MessengerRegisterInterface $messengerRegister
     */
    public function __construct(
        protected UrlGeneratorInterface $urlGenerator,
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        if (!$context->getUser()) {
            throw new FailedAuthorizeException();
        }

        $this->identifyUser($context->getUser()->getMessengerId());

        $gui->sendMessage('Ваш гардероб');
        $gui->sendReplyKeyboard($this->makeKeyboard());
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
        $request = new UrlGeneratorRequest(['api_token' => $this->apiToken]);

        return $this->urlGenerator->getWardrobeUrl($request)->getUrl();
    }

    /**
     * @return string
     */
    protected function getWardrobeOffersUrl(): string
    {
        $request = new UrlGeneratorRequest(['api_token' => $this->apiToken]);

        return $this->urlGenerator->getWardrobeOffersUrl($request)->getUrl();
    }
}
