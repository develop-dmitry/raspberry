<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Event;

use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;
use Raspberry\Look\Domain\Look\Services\Picker\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\Picker\PickerRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\PickerRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Picker\LookPickerHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class EventChooseHandler extends AbstractHandler
{
    protected PickerRepositoryInterface $pickerRepository;

    /**
     * @param LookPickerHandler $next
     * @param EventListHandler $back
     * @param EventRepositoryInterface $eventRepository
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected LookPickerHandler        $next,
        protected EventListHandler         $back,
        protected EventRepositoryInterface $eventRepository,
        GuiFactoryInterface                $guiFactory
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

        $this->pickerRepository = new PickerRepository($this->contextUser->getId()->getValue());

        if ($this->wasChosen()) {
            try {
                $this->saveEvent($this->getCallbackData()->get('id'));
                $this->next->handle($context, $messenger);
            } catch (FailedSavePropertyException | EventNotFoundException) {
                $messenger->sendMessage(Message::text('Произошла ошибка, попробуйте еще раз'));
            }
        } else {
            $this->back->handle($context, $messenger);
        }
    }

    protected function wasChosen(): bool
    {
        return $this->getCallbackData()->has('id');
    }

    /**
     * @param int $eventId
     * @throws FailedSavePropertyException
     * @throws EventNotFoundException
     */
    protected function saveEvent(int $eventId): void
    {
        if (!$this->eventRepository->isExists($eventId)) {
            throw new EventNotFoundException();
        }

        $this->pickerRepository->setEventId($eventId);
    }
}
