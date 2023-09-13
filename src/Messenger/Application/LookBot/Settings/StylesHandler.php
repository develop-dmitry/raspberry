<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Settings;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Exceptions\FailedSaveUserException;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\AddUserStyle\AddUserStyleInterface;
use Raspberry\Look\Application\AddUserStyle\DTO\AddUserStyleRequest;
use Raspberry\Look\Application\RemoveUserStyle\DTO\RemoveUserStyleRequest;
use Raspberry\Look\Application\RemoveUserStyle\RemoveUserStyleInterface;
use Raspberry\Look\Application\UserStyles\DTO\UserStylesRequest;
use Raspberry\Look\Application\UserStyles\UserStylesInterface;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;
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
     * @var int[]
     */
    protected array $styles;

    /**
     * @param StyleRepositoryInterface $styleRepository
     * @param UserStylesInterface $userStyles
     * @param RemoveUserStyleInterface $removeUserStyle
     * @param AddUserStyleInterface $addUserStyle
     * @param LoggerInterface $logger
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected StyleRepositoryInterface $styleRepository,
        protected UserStylesInterface $userStyles,
        protected RemoveUserStyleInterface $removeUserStyle,
        protected AddUserStyleInterface $addUserStyle,
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
            $this->styles = $this->getUserStyles();

            if ($this->wasChosen()) {
                $this->toggleStyle($this->getCallbackData()->get('id'));
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
        } catch (Exception) {
            $messenger->sendMessage(Message::text('Произошла ошибка, попробуйте позднее'));
        }
    }

    protected function wasChosen(): bool
    {
        return $this->getCallbackData()->getAction() === Action::StylesChoose->value &&
            $this->getCallbackData()->has('id');
    }

    /**
     * @param StyleInterface $item
     * @return InlineButtonInterface
     */
    protected function makeItemButton(mixed $item): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText($this->getStyleText($item))
            ->setCallbackData(
                new CallbackDataOption(Action::StylesChoose->value, [
                    'id' => $item->getId()->getValue(),
                    'page' => $this->page()
                ])
            )
            ->make();
    }

    /**
     * @param StyleInterface $style
     * @return string
     */
    protected function getStyleText(StyleInterface $style): string
    {
        $text = '';

        if ($this->isAlreadyHaving($style->getId()->getValue())) {
            $text .= '👉 ';
        }

        $text .= $style->getName()->getValue();

        return $text;
    }

    /**
     * @param int $styleId
     * @return bool
     */
    protected function isAlreadyHaving(int $styleId): bool
    {
        return in_array($styleId, $this->styles);
    }

    /**
     * @return array
     * @throws UnknownProperties
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    protected function getUserStyles(): array
    {
        $request = new UserStylesRequest(userId: $this->contextUser->getId()->getValue());

        return $this->userStyles
            ->execute($request)
            ->styles;
    }

    /**
     * @param int $styleId
     * @return void
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     * @throws UnknownProperties
     * @throws UserNotFoundException
     */
    protected function toggleStyle(int $styleId): void
    {
        if ($this->isAlreadyHaving($styleId)) {
            $this->addUserStyle($styleId);
        } else {
            $this->removeUserStyle($styleId);
        }
    }

    /**
     * @param int $styleId
     * @return void
     * @throws InvalidValueException
     * @throws UnknownProperties
     * @throws UserNotFoundException
     * @throws FailedSaveUserException
     * @throws StyleNotFoundException
     */
    protected function removeUserStyle(int $styleId): void
    {
        $request = new RemoveUserStyleRequest(userId: $this->contextUser->getId()->getValue(), styleId: $styleId);
        $this->removeUserStyle->execute($request);
    }

    /**
     * @param int $styleId
     * @return void
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     * @throws StyleNotFoundException
     * @throws UnknownProperties
     * @throws UserNotFoundException
     */
    protected function addUserStyle(int $styleId): void
    {
        $request = new AddUserStyleRequest(userId: $this->contextUser->getId()->getValue(), styleId: $styleId);
        $this->addUserStyle->execute($request);
    }

      /**
       * @inheritDoc
       */
    protected function action(): string
    {
        return Action::StylesUser->value;
    }
}
