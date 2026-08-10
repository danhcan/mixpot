<?php

namespace Inovector\Mixpost\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'accounts' => ['array'],
            'accounts.*' => ['integer'],
            'tags' => ['array'],
            'tags.*' => ['integer'],
            'versions' => ['required', 'array', 'min:1'],
            'versions.*.content.*.body' => ['nullable', 'string', 'max:5000'],
            'versions.*.content.*.media' => ['array'],
            'versions.*.content.*.media.*' => ['integer'],
        ];
    }
}
