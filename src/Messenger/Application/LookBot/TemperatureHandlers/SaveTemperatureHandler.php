<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\TemperatureHandlers;

use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\AuthorizeTrait;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

class SaveTemperatureHandler extends AbstractHandler
{
    use AuthorizeTrait;

    protected SelectionLookRepositoryInterface $selectionLookRepository;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        protected HandlerInterface $next,
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void
    {
        parent::handle($context, $gui, $args);

        $this->identifyUser($this->contextUser?->getMessengerId());
        $this->selectionLookRepository = new SelectionLookRepository($this->userId);

        try {
            $temperature = new Temperature($this->contextRequest->getMessage());
            $this->selectionLookRepository->setTemperature($temperature->getValue());

            $this->next->handle($context, $gui, $args);
        } catch (InvalidValueException) {
            $gui->sendMessage('Введена некорректная температура, попробуйте еще раз');
            $this->contextUser->setMessageHandler(TextAction::SaveTemperature->value);
        } catch (FailedSavePropertyException) {
            $gui->sendMessage('Произошла ошбика, попробуйте позднее');
        }
    }
}
