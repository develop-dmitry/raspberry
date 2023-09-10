<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Event;

use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\SelectionLook\SelectionLookHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class EventChooseHandler extends AbstractHandler
{
    protected SelectionLookRepositoryInterface $selectionLookRepository;

    /**
     * @param SelectionLookHandler $next
     * @param EventListHandler $back
     * @param EventRepositoryInterface $eventRepository
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected SelectionLookHandler $next,
        protected EventListHandler $back,
        protected EventRepositoryInterface $eventRepository,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

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

        $this->selectionLookRepository = new SelectionLookRepository($this->contextUser->getId()->getValue());

        if (!$this->contextRequest->getCallbackData()->has('id')) {
            $this->back->handle($context, $messenger);
        } else if ($this->saveEventId()) {
            $this->next->handle($context, $messenger);
        } else {
            $messenger->sendMessage(Message::text('Произошла ошибка, попробуйте еще раз'));
            $this->back->handle($context, $messenger);
        }
    }

    /**
     * @return bool
     */
    protected function saveEventId(): bool
    {
        $eventId = $this->contextRequest->getCallbackData()->get('id');

        if (!$this->eventRepository->isExists($eventId)) {
            return false;
        }

        try {
            $this->selectionLookRepository->setEventId($eventId);
        } catch (FailedSavePropertyException) {
            return false;
        }

        return true;
    }
}
