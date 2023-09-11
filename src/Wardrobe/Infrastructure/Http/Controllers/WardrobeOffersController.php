<?php

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\ClothesData;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Application\WardrobeOffers\WardrobeOffersInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Infrastructure\Http\Requests\WardrobeOffersPostRequest;

class WardrobeOffersController extends AbstractController
{
    public function __construct(
        protected WardrobeOffersInterface $wardrobeOffers
    ) {
    }

    public function __invoke(WardrobeOffersPostRequest $request): JsonResponse
    {
        $page = $request->validated('page');
        $count = $request->validated('count');

        $wardrobeOffersRequest = new WardrobeOffersRequest(
            userId: auth()->user()->id,
            page: $page,
            count: $count
        );

        try {
            $response = $this->wardrobeOffers->execute($wardrobeOffersRequest);

            return response()->json([
                'success' => true,
                'page' => $response->page,
                'count' => $response->count,
                'total' => $response->total,
                'offers' => array_map(static fn (ClothesData $clothes) => $clothes->toArray(), $response->items)
            ]);
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }
}
