<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\EventHandlers;

use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\HasAuthorize;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Messenger\MessengerGatewayInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

class EventChooseHandler extends AbstractHandler
{
    use HasAuthorize;

    protected SelectionLookRepositoryInterface $selectionLookRepository;

    public function __construct(
        protected HandlerInterface $next,
        protected HandlerInterface $back,
        protected EventRepositoryInterface $eventRepository,
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @param ContextInterface $context
     * @param MessengerGatewayInterface $messenger
     * @return void
     * @throws FailedAuthorizeException
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $this->identifyUser($context->getUser()?->getMessengerId());

        $this->selectionLookRepository = new SelectionLookRepository($this->userId);

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
