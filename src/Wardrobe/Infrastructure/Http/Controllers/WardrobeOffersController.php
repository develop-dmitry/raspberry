<?php

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
        $wardrobeOffersRequest = new WardrobeOffersRequest(auth()->user()->id, $page, $count);

        try {
            $wardrobeOffersResponse = $this->wardrobeOffers->execute($wardrobeOffersRequest);

            return $this->handleOffersResponse($wardrobeOffersResponse);
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }

    public function handleOffersResponse(WardrobeOffersResponse $response): JsonResponse
    {
        $offers = [];

        foreach ($response->getOffers() as $offer) {
            $offers[] = [
                'id' => $offer->getId(),
                'name' => $offer->getName(),
                'slug' => $offer->getSlug(),
                'photo' => $offer->getPhoto()
            ];
        }

        $data = [
            'success' => true,
            'offers' => $offers,
            'page' => $response->getPage(),
            'count' => $response->getCount(),
            'total' => $response->getTotal()
        ];

        return response()->json($data);
    }
}
