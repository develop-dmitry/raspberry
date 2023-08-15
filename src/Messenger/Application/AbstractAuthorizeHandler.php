<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Exception;
use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationRequest;
use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterRequest;
use Raspberry\Authorization\Application\MessengerRegister\MessengerRegisterInterface;
use Raspberry\Authorization\Domain\User\Exceptions\FailedSaveUserException;
use Raspberry\Authorization\Domain\User\Exceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;

class AbstractAuthorizeHandler extends AbstractHandler
{
    protected int $userId;

    /**
     * @param MessengerAuthorizationInterface $messengerAuthorization
     * @param MessengerRegisterInterface $messengerRegister
     */
    public function __construct(
        private readonly MessengerAuthorizationInterface $messengerAuthorization,
        private readonly MessengerRegisterInterface $messengerRegister
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        try {
            $this->authorize();
        } catch (UserNotFoundException) {
            $this->register();
        } catch (Exception $exception) {
            throw new FailedAuthorizeException($exception->getMessage());
        }
    }

    /**
     * @return void
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    private function authorize(): void
    {
        $authRequest = new MessengerAuthorizationRequest($this->contextUser->getMessengerId());
        $authResponse = $this->messengerAuthorization->execute($authRequest);

        $this->userId = $authResponse->getUserId();
    }

    /**
     * @return void
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    private function register(): void
    {
        $registerRequest = new MessengerRegisterRequest($this->contextUser->getMessengerId());
        $registerResponse = $this->messengerRegister->execute($registerRequest);

        $this->userId = $registerResponse->getUserId();
    }
}
