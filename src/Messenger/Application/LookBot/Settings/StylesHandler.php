<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Settings;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Look\Application\StylesUser\DTO\HasStyleRequest;
use Raspberry\Look\Application\StylesUser\DTO\ToggleStyleRequest;
use Raspberry\Look\Application\StylesUser\StylesUserInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Messenger\Application\AbstractPaginationHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

class StylesHandler extends AbstractPaginationHandler
{
    use AuthorizeTrait;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        protected StyleRepositoryInterface $styleRepository,
        protected StylesUserInterface $stylesUser,
        protected LoggerInterface $logger
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        if (!$context->getUser()) {
            throw new FailedAuthorizeException();
        }

        $this->identifyUser($context->getUser()->getMessengerId());

        if ($this->getCallbackData()->getAction() === Action::StylesChoose->value) {
            $this->toggleStyle();
        }

        $this->pagination = $this->styleRepository->paginate($this->page(), 10);

        if ($this->contextRequest->getRequestType() === HandlerType::CallbackQuery) {
            $gui->editMessage();
        }

        $gui->sendMessage('Выберите стили в одежде, которые вы предпочитаете');
        $gui->sendInlineKeyboard($this->makePaginationKeyboard());
    }

    /**
     * @param StyleInterface $item
     * @return InlineButtonInterface
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
     */
    protected function hasStyle(int $styleId): bool
    {
        $hasStyleRequest = new HasStyleRequest($this->userId, $styleId);

        try {
            return $this->stylesUser->hasStyle($hasStyleRequest)->hasStyle();
        } catch (Exception) {
            return false;
        }
    }

    protected function toggleStyle(): void
    {
        $callbackData = $this->getCallbackData();

        if (!$callbackData->has('id')) {
            return;
        }

        $styleId = $callbackData->get('id');
        $toggleStyleRequest = new ToggleStyleRequest($this->userId, $styleId);

        try {
            $this->stylesUser->toggleStyle($toggleStyleRequest);
        } catch (Exception $exception) {
            $this->logger->error('Failed toggle styles user', [
                'style_id' => $styleId,
                'user_id' => $this->userId,
                'exception' => $exception->getMessage()
            ]);
        }
    }
}
