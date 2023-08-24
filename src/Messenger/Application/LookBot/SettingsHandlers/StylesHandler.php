<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\SettingsHandlers;

use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Messenger\Application\AbstractPaginationHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

class StylesHandler extends AbstractPaginationHandler
{
    use AuthorizeTrait;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        protected StyleRepositoryInterface $styleRepository
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        if (!$context->getUser()) {
            throw new FailedAuthorizeException();
        }

        $this->identifyUser($context->getUser()->getMessengerId());
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
        return $this->inlineButtonFactory
            ->setText($item->getName()->getValue())
            ->setCallbackData(new CallbackDataOption('test123', []))
            ->make();
    }

    /**
     * @inheritDoc
     */
    protected function action(): string
    {
        return Action::StylesUser->value;
    }
}
