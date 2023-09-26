<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;

class DetailLookController extends AbstractController
{
    public function __construct(
        protected DetailLookInterface $detailLook
    ) {
    }

    public function __invoke(int $lookId, Request $request)
    {
        try {
            $detailRequest = new DetailLookRequest(id: $lookId);
            $detailResponse = $this->detailLook->execute($detailRequest);

            return Inertia::render('LookDetailPage', ['look' => $detailResponse->toArray()])
                ->toResponse($request);
        } catch (LookNotFoundException) {
            return Inertia::render('NotFoundPage')
                ->toResponse($request)
                ->setStatusCode(404);
        }
    }
}
