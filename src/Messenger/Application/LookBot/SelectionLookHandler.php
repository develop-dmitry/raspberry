<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlInterface;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\SelectionLook\DTO\LookItem;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\SelectionLookInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\WebAppOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

class SelectionLookHandler extends AbstractHandler
{

    use AuthorizeTrait;

    public function __construct(
        protected SelectionLookInterface $selectionLook,
        protected DetailLookUrlInterface $detailLookUrl,
        protected LoggerInterface $logger,
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        $this->identifyUser($context->getUser()?->getMessengerId());

        $selectionRequest = new SelectionLookRequest($this->userId);

        $selectionResponse = $this->selectionLook->execute($selectionRequest);
        $looks = $selectionResponse->getLooks();

        if ($context->getRequest()->getRequestType() === HandlerType::CallbackQuery) {
            $gui->editMessage();
        }

        if (empty($looks)) {
            $gui->sendMessage('К сожалению, мы не смогли подобрать для вас образ :(');
        } else {
            $gui
                ->sendMessage('Для вас подобраны следующие образы')
                ->sendInlineKeyboard($this->makeKeyboard($looks));
        }
    }

    /**
     * @param LookItem[] $looks
     * @return InlineKeyboardInterface
     */
    protected function makeKeyboard(array $looks): InlineKeyboardInterface
    {
        $keyboard = $this->inlineKeyboardFactory->make();

        foreach (array_slice($looks, 0, 5) as $look) {
            try {
                $keyboard->addRow($this->makeButton($look));
            } catch (Exception $exception) {
                $this->logger->error('Failed to make look button', [
                    'exception' => $exception->getMessage(),
                    'look' => $look->toArray()
                ]);

                continue;
            }
        }

        return $keyboard;
    }

    /**
     * @param LookItem $item
     * @return InlineButtonInterface
     * @throws FailedUrlGenerateException
     * @throws LookNotFoundException
     */
    protected function makeButton(LookItem $item): InlineButtonInterface
    {
        $this->logger->debug('Look url', ['url' => $this->makeUrl($item)]);
        return $this->inlineButtonFactory
            ->setText($item->getName())
            ->setWebApp(new WebAppOption($this->makeUrl($item)))
            ->make();
    }

    /**
     * @throws FailedUrlGenerateException
     * @throws LookNotFoundException
     */
    protected function makeUrl(LookItem $item): string
    {
        $request = new DetailLookUrlRequest($item->getId(), ['api_token' => $this->apiToken]);

        return $this->detailLookUrl->execute($request)->getUrl();
    }
}
