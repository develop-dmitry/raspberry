<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DTO\ClothesItem;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookResponse;
use Raspberry\Look\Application\DetailLook\DTO\EventItem;
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
        return response()->json([
            'success' => true,
            'look' => [
                'id' => $response->getId(),
                'name' => $response->getName(),
                'slug' => $response->getSlug(),
                'photo' => $response->getPhoto(),
                'clothes' => array_map([$this, 'clothesToArray'], $response->getClothes()),
                'events' => array_map([$this, 'eventToArray'], $response->getEvents())
            ]
        ]);
    }

    /**
     * @param ClothesItem $clothes
     * @return array
     */
    protected function clothesToArray(ClothesItem $clothes): array
    {
        return [
            'id' => $clothes->getId(),
            'photo' => $clothes->getPhoto(),
            'name' => $clothes->getName()
        ];
    }

    /**
     * @param EventItem $event
     * @return array
     */
    protected function eventToArray(EventItem $event): array
    {
        return [
            'name' => $event->getName()
        ];
    }

    /**
     * @return JsonResponse
     */
    protected function lookNotFound(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Образ не найден');

        return response()->json($response);
    }
}
