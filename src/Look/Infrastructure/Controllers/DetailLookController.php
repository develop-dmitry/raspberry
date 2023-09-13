<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DetailLookController extends AbstractController
{
    public function __construct(
        protected DetailLookInterface $detailLook
    ) {
    }

    public function __invoke(int $lookId): JsonResponse
    {
        try {
            $detailRequest = new DetailLookRequest(id: $lookId);
            $detailResponse = $this->detailLook->execute($detailRequest);

            return response()->json([
                'success' => true,
                'look' => $detailResponse->toArray()
            ]);
        } catch (LookNotFoundException) {
            return $this->lookNotFound();
        } catch (UnknownProperties) {
            return $this->unexpectedError();
        }
    }
}
