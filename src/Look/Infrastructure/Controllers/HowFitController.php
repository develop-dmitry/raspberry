<?php

namespace Raspberry\Look\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Core\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\HowFit\DTO\HowFitRequest;
use Raspberry\Look\Application\HowFit\HowFitInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class HowFitController extends AbstractController
{

    /**
     * @param HowFitInterface $howFit
     */
    public function __construct(
        protected HowFitInterface $howFit
    ) {
    }

    public function __invoke(int $lookId): JsonResponse
    {
        try {
            $howFitRequest = new HowFitRequest(
                userId: auth()->user()->id,
                lookId: $lookId
            );
            $howFitResponse = $this->howFit->execute($howFitRequest);

            return response()->json([
                'success' => true,
                'how_fit' => $howFitResponse->percent
            ]);
        } catch (LookNotFoundException) {
            return $this->lookNotFound();
        } catch (UserNotFoundException) {
            return $this->userNotFound();
        } catch (InvalidValueException|UnknownProperties) {
            return $this->unexpectedError();
        }
    }
}
