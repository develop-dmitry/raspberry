<?php

namespace Raspberry\Look\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AbstractController extends Controller
{

    /**
     * @return JsonResponse
     */
    protected function lookNotFound(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Образ не найден');

        return response()->json($response);
    }

    /**
     * @return JsonResponse
     */
    protected function userNotFound(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Пользователь не найден');

        return response()->json($response);
    }

    /**
     * @return JsonResponse
     */
    protected function unexpectedError(): JsonResponse
    {
        $response = $this->makeDefaultResponse(false, 'Неожиданная ошибка');

        return response()->json($response);
    }
}
