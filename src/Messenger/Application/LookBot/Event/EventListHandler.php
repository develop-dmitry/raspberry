<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Event;

use Psr\Log\LoggerInterface;
use Raspberry\Look\Domain\Event\EventInterface;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Messenger\Application\AbstractPaginationHandler;
use Raspberry\Messenger\Application\LookBot\Enums\Action;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\InlineButton\CallbackDataOption;
use Raspberry\Messenger\Domain\Gui\Options\OptionInterface;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class EventListHandler extends AbstractPaginationHandler
{

    protected int $perPage = 10;

    /**
     * @param EventRepositoryInterface $eventRepository
     * @param LoggerInterface $logger
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected EventRepositoryInterface $eventRepository,
        protected LoggerInterface $logger,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $this->pagination = $this->eventRepository->withLooks($this->page(), $this->perPage);

        if (!$this->requestFromCurrentHandler()) {
            $messenger->sendMessage(Message::removeKeyboard(
                'Выберите мероприятие, для которого хотите подобрать образ'
            ));
        }

        $message = Message::withInlineKeyboard(
            'Список мероприятий',
            $this->makePaginationKeyboard()
        );

        if ($this->requestFromCurrentHandler()) {
            $messenger->editMessage($message);
        } else {
            $messenger->sendMessage($message);
        }
    }

    /**
     * @return bool
     */
    protected function requestFromCurrentHandler(): bool
    {
        return  $this->getCallbackData()->getAction() === Action::EventChoose->value
            || $this->getCallbackData()->get('pagination', false);
    }

    /**
     * @param mixed $item
     * @return InlineButtonInterface
     */
    protected function makeItemButton(mixed $item): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText($item->getName()->getValue())
            ->setCallbackData($this->makeCallbackData($item))
            ->make();
    }

    /**
     * @param EventInterface $event
     * @return OptionInterface
     */
    protected function makeCallbackData(EventInterface $event): OptionInterface
    {
        return new CallbackDataOption(Action::EventChoose->value, ['id' => $event->getId()->getValue()]);
    }

    /**
     * @inheritDoc
     */
    protected function action(): string
    {
        return Action::EventList->value;
    }
}
