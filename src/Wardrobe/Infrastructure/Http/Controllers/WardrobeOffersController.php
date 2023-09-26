<?php

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\ClothesData;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Application\WardrobeOffers\WardrobeOffersInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Infrastructure\Http\Requests\WardrobeOffersPostRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class WardrobeOffersController extends AbstractController
{
    public function __construct(
        protected WardrobeOffersInterface $wardrobeOffers
    ) {
    }

    public function __invoke(Request $request)
    {
        $count = 21;

        try {
            $response = $this->getUserOffers(auth()->user()->id, 1, $count);

            return Inertia::render('OffersPage', ['count' => $count, 'total' => $response->total])
                ->toResponse($request);
        } catch (UserDoesNotExistsException) {
            return Inertia::render('NotFoundPage')
                ->toResponse($request)
                ->setStatusCode(404);
        }
    }

    public function userOffers(WardrobeOffersPostRequest $request): JsonResponse
    {
        $page = $request->validated('page');
        $count = $request->validated('count');

        try {
            $response = $this->getUserOffers(auth()->user()->id, $page, $count);

            return response()->json(array_merge(['success' => true], $response->toArray()));
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $count
     * @return WardrobeOffersResponse
     * @throws UserDoesNotExistsException
     * @throws UnknownProperties
     */
    protected function getUserOffers(int $userId, int $page, int $count): WardrobeOffersResponse
    {
        $request = new WardrobeOffersRequest(userId: $userId, page: $page, count: $count);

        return $this->wardrobeOffers->execute($request);
    }
}
