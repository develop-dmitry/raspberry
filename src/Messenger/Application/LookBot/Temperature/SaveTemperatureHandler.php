<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\HasAuthorize;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Gui\Messenger\MessengerGatewayInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;

class SaveTemperatureHandler extends AbstractHandler
{
    use HasAuthorize;

    protected SelectionLookRepositoryInterface $selectionLookRepository;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization,
        protected MessengerRegisterInterface $messengerRegister,
        protected HandlerInterface $next,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    /**
     * @param ContextInterface $context
     * @param MessengerGatewayInterface $messenger
     * @return void
     * @throws InvalidValueException
     * @throws FailedSaveUserException
     * @throws FailedAuthorizeException
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $this->identifyUser($this->contextUser?->getMessengerId());
        $this->selectionLookRepository = new SelectionLookRepository($this->userId);

        try {
            $temperature = new Temperature($this->contextRequest->getMessage());
            $this->selectionLookRepository->setTemperature($temperature->getValue());

            $this->next->handle($context, $messenger);
        } catch (InvalidValueException) {
            $messenger->sendMessage(Message::text('Введена некорректная температура, попробуйте еще раз'));
            $this->contextUser->setMessageHandler(TextAction::SaveTemperature->value);
        } catch (FailedSavePropertyException) {
            $messenger->sendMessage(Message::text('Произошла ошбика, попробуйте позднее'));
        }
    }
}
