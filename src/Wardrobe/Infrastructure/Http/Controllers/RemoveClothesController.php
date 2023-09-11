<?php

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Wardrobe\Application\RemoveClothes\DTO\RemoveClothesRequest;
use Raspberry\Wardrobe\Application\RemoveClothes\RemoveClothesInterface;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Infrastructure\Http\Requests\RemoveClothesPostRequest;

class RemoveClothesController extends AbstractController
{
    public function __construct(
        protected RemoveClothesInterface $removeClothes
    ) {
    }

    public function __invoke(RemoveClothesPostRequest $request): JsonResponse
    {
        $clothesId = (int) $request->validated('clothes_id');
        $removeClothesRequest = new RemoveClothesRequest(
            userId: auth()->user()->id,
            clothesId: $clothesId
        );

        try {
            $this->removeClothes->execute($removeClothesRequest);
            $response = $this->makeDefaultResponse(true, 'Одежда успешно удалена');

            return response()->json($response);
        } catch (ClothesNotFoundException) {
            return $this->clothesNotFound();
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }
}
