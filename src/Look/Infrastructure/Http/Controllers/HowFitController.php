<?php

namespace Raspberry\Look\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\HowFit\DTO\HowFitRequest;
use Raspberry\Look\Application\HowFit\HowFitInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;

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
            $howFitResponse = $this->howFit->execute(new HowFitRequest(auth()->user()->id, $lookId));

            return response()->json([
                'success' => true,
                'how_fit' => $howFitResponse->getPercent()
            ]);
        } catch (LookNotFoundException) {
            return $this->lookNotFound();
        } catch (UserNotFoundException) {
            return $this->userNotFound();
        } catch (InvalidValueException) {
            return $this->unexpectedError();
        }
    }
}
