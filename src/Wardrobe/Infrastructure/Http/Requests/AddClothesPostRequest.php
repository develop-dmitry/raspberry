<?php

namespace Raspberry\Wardrobe\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddClothesPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'clothes_id' => 'required|numeric',
        ];
    }
}
