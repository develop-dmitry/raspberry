<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListRequest;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListResponse;
use Raspberry\Wardrobe\Application\WardrobeList\WardrobeListInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class WardrobeController extends AbstractController
{
    public function __construct(
        protected WardrobeListInterface $wardrobeList
    ) {
    }

    public function __invoke(Request $request)
    {
        try {
            $response = $this->getUserWardrobe(auth()->user()->id);

            return Inertia::render('WardrobePage', $response->toArray())
                ->toResponse($request);
        } catch (UserDoesNotExistsException) {
            return Inertia::render('NotFoundPage')
                ->toResponse($request)
                ->setStatusCode(404);
        }
    }

    public function userWardrobe(): JsonResponse
    {
        try {
            $response = $this->getUserWardrobe(auth()->user()->id);

            return response()->json(array_merge(['success' => true], $response->toArray()));
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }

    /**
     * @param int $userId
     * @return WardrobeListResponse
     * @throws UserDoesNotExistsException
     * @throws UnknownProperties
     */
    protected function getUserWardrobe(int $userId): WardrobeListResponse
    {
        $request = new WardrobeListRequest(userId: $userId);

        return $this->wardrobeList->execute($request);
    }
}
