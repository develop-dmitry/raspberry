<?php

namespace Raspberry\Look\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HowFitPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric',
        ];
    }
}
