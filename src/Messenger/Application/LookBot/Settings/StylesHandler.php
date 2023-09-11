<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Settings;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\StylesUser\StylesUserInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Messenger\Application\AbstractPaginationHandler;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Handlers\HandlerType;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class StylesHandler extends AbstractPaginationHandler
{

    /**
     * @param StyleRepositoryInterface $styleRepository
     * @param StylesUserInterface $stylesUser
     * @param LoggerInterface $logger
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected StyleRepositoryInterface $styleRepository,
        protected StylesUserInterface $stylesUser,
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

        try {
            if ($this->getCallbackData()->getAction() === Action::StylesChoose->value) {
                $this->toggleStyle();
            }

            $this->pagination = $this->styleRepository->paginate($this->page(), 10);

            $message = Message::withInlineKeyboard(
                'Выберите стили в одежде, которые вы предпочитаете',
                $this->makePaginationKeyboard()
            );

            if ($this->getRequestType() === HandlerType::CallbackQuery) {
                $messenger->editMessage($message);
            } else {
                $messenger->sendMessage($message);
            }
        } catch (UnknownProperties) {
            $messenger->sendMessage(Message::text('Произошла ошибка, попробуйте позднее'));
        }
    }

    /**
     * @param StyleInterface $item
     * @return InlineButtonInterface
     * @throws UnknownProperties
     */
    protected function makeItemButton(mixed $item): InlineButtonInterface
    {
        $styleId = $item->getId()->getValue();
        $text = $item->getName()->getValue();

        if ($this->hasStyle($styleId)) {
            $text = "👉 $text";
        }

        $callbackData = new CallbackDataOption(
            Action::StylesChoose->value,
            [
                'id' => $styleId,
                'page' => $this->page()
            ]
        );

        return $this->inlineButtonFactory
            ->setText($text)
            ->setCallbackData($callbackData)
            ->make();
    }

    /**
     * @inheritDoc
     */
    protected function action(): string
    {
        return Action::StylesUser->value;
    }

    /**
     * @param int $styleId
     * @return bool
     * @throws UnknownProperties
     */
    protected function hasStyle(int $styleId): bool
    {
        $hasStyleRequest = new HasStyleRequest(
            userId: $this->contextUser->getId()->getValue(),
            styleId: $styleId
        );

        try {
            return $this->stylesUser->hasStyle($hasStyleRequest)->hasStyle;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @return void
     * @throws UnknownProperties
     */
    protected function toggleStyle(): void
    {
        $callbackData = $this->getCallbackData();

        if (!$callbackData->has('id')) {
            return;
        }

        $styleId = $callbackData->get('id');
        $toggleStyleRequest = new ToggleStyleRequest(
            userId: $this->contextUser->getId()->getValue(),
            styleId: $styleId
        );

        try {
            $this->stylesUser->toggleStyle($toggleStyleRequest);
        } catch (Exception $exception) {
            $this->logger->error('Failed toggle styles user', [
                'style_id' => $styleId,
                'user_id' => $this->contextUser->getId()->getValue(),
                'exception' => $exception->getMessage()
            ]);
        }
    }
}
