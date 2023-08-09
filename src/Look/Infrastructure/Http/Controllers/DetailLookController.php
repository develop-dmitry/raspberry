<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\AbstractController;

class DetailLookController extends AbstractController
{
    public function __construct(
        protected DetailLookInterface $detailLook
    ) {
    }

    public function __invoke(int $lookId): JsonResponse
    {
        try {
            $detailRequest = new DetailLookRequest($lookId);
            $detailResponse = $this->detailLook->execute($detailRequest);

            return $this->makeResponse($detailResponse);
        } catch (LookNotFoundException) {
            return $this->lookNotFound();
        }
    }

    protected function makeResponse(DetailLookResponse $response): JsonResponse
    {
        $clothes = [];

        foreach ($response->getClothes() as $item) {
            $clothes[] = [
                'id' => $item->getId(),
                'photo' => $item->getPhoto(),
                'name' => $item->getName()
            ];
        }

        return response()->json([
            'success' => true,
            'look' => [
                'id' => $response->getId(),
                'name' => $response->getName(),
                'slug' => $response->getSlug(),
                'photo' => $response->getPhoto(),
                'clothes' => $clothes
            ]
        ]);
    }

    protected function lookNotFound(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Образ не найден');

        return response()->json($response);
    }
}
