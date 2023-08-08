<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AbstractController extends Controller
{

    protected function clothesNotFound(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Одежда не найдена');

        return response()->json($response);
    }

    protected function clothesAlreadyExists(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Одежда уже есть в гардеробе');

        return response()->json($response);
    }

    protected function userDoesNotExists(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Не узнаем вас');

        return response()->json($response);
    }
}
