<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\EventHandlers;

use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Messenger\Application\AbstractPaginationHandler;
use Raspberry\Messenger\Application\LookBot\Enums\ActionEnum;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;

class EventListHandler extends AbstractPaginationHandler
{

    protected int $perPage = 10;

    public function __construct(
        protected EventRepositoryInterface $eventRepository
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        $this->pagination = $this->eventRepository->pagination($this->page(), $this->perPage);

        if ($this->contextRequest->getRequestType() === HandlerTypeEnum::CallbackQuery) {
            $gui->editMessage();
        }

        $gui->sendMessage('Выберите мероприятие, для которого хотите подобрать образ');
        $gui->sendInlineKeyboard($this->makeKeyboard());
    }

    protected function makeKeyboard(): InlineKeyboardInterface
    {
        $keyboard = $this->inlineKeyboardFactory->make();

        foreach ($this->pagination->getItems() as $item) {
            $keyboard->addRow($this->makeButton($item));
        }

        if ($this->canSwitchPage()) {
            $keyboard->addRow(...$this->makePaginationRow());
        }

        return $keyboard;
    }

    protected function makeButton(EventInterface $event): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText($event->getName()->getValue())
            ->setCallbackData($this->makeCallbackData($event))
            ->make();
    }

    protected function makeCallbackData(EventInterface $event): OptionInterface
    {
        return new CallbackDataOption(
            ActionEnum::EventChoose->value,
            ['id' => $event->getId()->getValue()]
        );
    }

    /**
     * @inheritDoc
     */
    protected function action(): string
    {
        return ActionEnum::EventList->value;
    }
}
