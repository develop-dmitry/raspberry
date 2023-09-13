<?php

namespace Raspberry\Look\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\PickerScore\DTO\PickerScoreRequest;
use Raspberry\Look\Application\PickerScore\DTO\PickerScoreResponse;
use Raspberry\Look\Application\PickerScore\PickerScoreInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PickerScoreController extends AbstractController
{

    /**
     * @param PickerScoreInterface $pickerScore
     */
    public function __construct(
        protected PickerScoreInterface $pickerScore
    ) {
    }

    /**
     * @param int $lookId
     * @return JsonResponse
     */
    public function __invoke(int $lookId): JsonResponse
    {
        try {
            $response = $this->getPickerScore($lookId, auth()->id());

            return response()->json([
                'success' => true,
                'how_fit' => $response->percent
            ]);
        } catch (LookNotFoundException) {
            return $this->lookNotFound();
        } catch (UserNotFoundException) {
            return $this->userNotFound();
        } catch (InvalidValueException|UnknownProperties) {
            return $this->unexpectedError();
        }
    }


    /**
     * @param int $lookId
     * @param int $userId
     * @return PickerScoreResponse
     * @throws InvalidValueException
     * @throws LookNotFoundException
     * @throws UnknownProperties
     * @throws UserNotFoundException
     */
    protected function getPickerScore(int $lookId, int $userId): PickerScoreResponse
    {
        $request = new PickerScoreRequest(userId: $userId, lookId: $lookId);

        return $this->pickerScore->execute($request);
    }
}
