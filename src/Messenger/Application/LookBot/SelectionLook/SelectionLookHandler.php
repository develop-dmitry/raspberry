<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\SelectionLook;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlInterface;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\SelectionLook\DTO\LookItem;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\SelectionLookInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\WebAppOption;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class SelectionLookHandler extends AbstractHandler
{

    /**
     * @param SelectionLookInterface $selectionLook
     * @param DetailLookUrlInterface $detailLookUrl
     * @param LoggerInterface $logger
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected SelectionLookInterface $selectionLook,
        protected DetailLookUrlInterface $detailLookUrl,
        protected LoggerInterface $logger,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @inheritDoc
     */
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

        $selectionRequest = new SelectionLookRequest($this->contextUser->getId()->getValue());

        $selectionResponse = $this->selectionLook->execute($selectionRequest);
        $looks = $selectionResponse->getLooks();

        if (empty($looks)) {
            $message = Message::text('К сожалению, мы не смогли подобрать для вас образ :(');
        } else {
            $message = Message::withInlineKeyboard(
                'Для вас подобраны следующие образы',
                $this->makeKeyboard($looks)
            );
        }

        if ($this->getRequestType() === HandlerType::CallbackQuery) {
            $messenger->editMessage($message);
        } else {
            $messenger->sendMessage($message);
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
        $request = new DetailLookUrlRequest($item->getId(), [
            'api_token' => $this->contextUser->getApiToken()->getValue()
        ]);

        return $this->detailLookUrl->execute($request)->getUrl();
    }
}
