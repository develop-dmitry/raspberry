<?php

namespace Raspberry\Wardrobe\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WardrobeOffersPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'required|numeric',
            'count' => 'required|numeric'
        ];
    }
}
