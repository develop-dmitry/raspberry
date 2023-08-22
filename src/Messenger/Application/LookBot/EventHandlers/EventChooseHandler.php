<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\EventHandlers;

use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArguments;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;

class EventChooseHandler extends AbstractHandler
{
    use AuthorizeTrait;

    protected SelectionLookRepositoryInterface $selectionLookRepository;

    public function __construct(
        protected HandlerInterface $next,
        protected HandlerInterface $back,
        protected EventRepositoryInterface $eventRepository,
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        if (!$context->getUser()) {
            throw new FailedAuthorizeException();
        }

        $this->identifyUser($context->getUser()->getMessengerId());
        $this->selectionLookRepository = new SelectionLookRepository($this->userId);

        if (!$this->contextRequest->getCallbackData()->has('id')) {
            $this->back($context, $gui, null);
        } else if ($this->saveEventId()) {
            $this->next($context, $gui);
        } else {
            $this->back($context, $gui, new HandlerArguments('Произошла ошибка, попробуйте еще раз'));
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

    /**
     * @param ContextInterface $context
     * @param GuiInterface $gui
     * @return void
     * @throws FailedAuthorizeException
     */
    protected function next(ContextInterface $context, GuiInterface $gui): void
    {
        $this->next->handle($context, $gui);
    }

    /**
     * @param ContextInterface $context
     * @param GuiInterface $gui
     * @param HandlerArgumentsInterface|null $args
     * @return void
     * @throws FailedAuthorizeException
     */
    protected function back(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args): void
    {
        $this->back->handle($context, $gui, $args);
    }
}
