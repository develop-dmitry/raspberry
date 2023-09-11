<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Raspberry\Wardrobe\Application\AddClothes\AddClothesInterface;
use Raspberry\Wardrobe\Application\AddClothes\DTO\AddClothesRequest;
use Raspberry\Wardrobe\Domain\Clothes\Exceptions\ClothesNotFoundException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\ClothesAlreadyExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Infrastructure\Http\Requests\AddClothesPostRequest;

class AddClothesController extends AbstractController
{
    public function __construct(
        protected AddClothesInterface $addClothes
    ) {
    }

    public function __invoke(AddClothesPostRequest $request): JsonResponse
    {
        $clothesId = (int) $request->validated('clothes_id');

        $addClothesRequest = new AddClothesRequest(
            userId: auth()->user()->id,
            clothesId: $clothesId
        );

        try {
            $this->addClothes->execute($addClothesRequest);
            $response = $this->makeDefaultResponse(true, 'Одежда успешно добавлена');

            return response()->json($response);
        } catch (ClothesNotFoundException) {
            return $this->clothesNotFound();
        } catch (ClothesAlreadyExistsException) {
            return $this->clothesAlreadyExists();
        } catch (UserDoesNotExistsException) {
            return $this->userDoesNotExists();
        }
    }
}
