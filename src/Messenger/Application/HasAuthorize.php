<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Exception;
use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationRequest;
use Raspberry\Authorization\Application\MessengerRegister\DTO\MessengerRegisterRequest;
use Raspberry\Common\Exceptions\UserExceptions\FailedSaveUserException;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;

trait HasAuthorize
{
    protected int $userId;

    protected string $apiToken;

    /**
     * @param int|null $messengerId
     * @return void
     * @throws FailedAuthorizeException
     * @throws FailedSaveUserException
     * @throws InvalidValueException
     */
    protected function identifyUser(?int $messengerId): void
    {
        if (!$messengerId) {
            throw new FailedAuthorizeException();
        }

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
        $this->apiToken = $authResponse->getApiToken();
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
        $this->apiToken = $registerResponse->getApiToken();
    }
}
