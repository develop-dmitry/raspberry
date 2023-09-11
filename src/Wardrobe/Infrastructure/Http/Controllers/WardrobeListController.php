<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListRequest;
use Raspberry\Wardrobe\Application\WardrobeList\DTO\WardrobeListResponse;
use Raspberry\Wardrobe\Application\WardrobeList\WardrobeListInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;

class WardrobeListController extends AbstractController
{
    public function __construct(
        protected WardrobeListInterface $wardrobeList
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $wardrobeListRequest = new WardrobeListRequest(userId: auth()->user()->id);

        try {
            $response = $this->wardrobeList->execute($wardrobeListRequest);
            $response = array_merge(['success' => true], $response->toArray());

            return response()->json($response);
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }
}
