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

trait AuthorizeTrait
{
    protected int $userId;

    /**
     * @param int $messengerId
     * @return void
     * @throws FailedAuthorizeException
     */
    protected function identifyUser(int $messengerId): void
    {
        try {
            $this->authorize($messengerId);
        } catch (UserNotFoundException) {
            $this->register($messengerId);
        } catch (Exception $exception) {
            throw new FailedAuthorizeException($exception->getMessage());
        }
    }

    /**
     * @param int $messengerId
     * @return void
     * @throws InvalidValueException
     * @throws UserNotFoundException
     */
    private function authorize(int $messengerId): void
    {
        $authRequest = new MessengerAuthorizationRequest($messengerId);
        $authResponse = $this->messengerAuthorization->execute($authRequest);

        $this->userId = $authResponse->getUserId();
    }

    /**
     * @param int $messengerId
     * @return void
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    private function register(int $messengerId): void
    {
        $registerRequest = new MessengerRegisterRequest($messengerId);
        $registerResponse = $this->messengerRegister->execute($registerRequest);

        $this->userId = $registerResponse->getUserId();
    }
}
