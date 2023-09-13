<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\SelectionLook;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\LookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\LookUrl\LookUrlInterface;
use Raspberry\Look\Application\Picker\DTO\LookData;
use Raspberry\Look\Application\Picker\DTO\PickerRequest;
use Raspberry\Look\Application\Picker\PickerInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\Exceptions\FailedUrlGenerateException;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\WebAppOption;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SelectionLookHandler extends AbstractHandler
{

    /**
     * @param PickerInterface $picker
     * @param LookUrlInterface $detailLookUrl
     * @param LoggerInterface $logger
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected PickerInterface  $picker,
        protected LookUrlInterface $detailLookUrl,
        protected LoggerInterface  $logger,
        GuiFactoryInterface        $guiFactory
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

        try {
            $request = new PickerRequest(userId: $this->contextUser->getId()->getValue());

            $response = $this->picker->execute($request);

            if (empty($response->looks)) {
                $message = Message::text('К сожалению, мы не смогли подобрать для вас образ :(');
            } else {
                $message = Message::withInlineKeyboard(
                    'Для вас подобраны следующие образы',
                    $this->makeKeyboard($response->looks)
                );
            }

            if ($this->getRequestType() === HandlerType::CallbackQuery) {
                $messenger->editMessage($message);
            } else {
                $messenger->sendMessage($message);
            }
        } catch (UserNotFoundException | InvalidValueException | UnknownProperties) {
            $messenger->sendMessage(Message::text('Произошла ошибка, попробуйте позднее'));
        }
    }

    /**
     * @param LookData[] $looks
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
     * @param LookData $item
     * @return InlineButtonInterface
     * @throws FailedUrlGenerateException
     * @throws LookNotFoundException
     * @throws UnknownProperties
     */
    protected function makeButton(LookData $item): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText($item->name)
            ->setWebApp(new WebAppOption($this->makeUrl($item)))
            ->make();
    }

    /**
     * @throws FailedUrlGenerateException
     * @throws LookNotFoundException
     * @throws UnknownProperties
     */
    protected function makeUrl(LookData $item): string
    {
        $request = new DetailLookUrlRequest(
            lookId: $item->id,
            query: ['api_token' => $this->contextUser->getApiToken()->getValue()]
        );

        return $this->detailLookUrl->generateDetailUrl($request)->url;
    }
}
