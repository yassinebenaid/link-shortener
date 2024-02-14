<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLinkRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->slug ? $this->slug : str()->ulid()->toBase58(),
        ]);
    }

    public function rules(): array
    {
        return [
            'original' => 'required|string|max:255|url',
            'slug' => 'required|string|max:255|regex:#^[A-z0-9]+(-[A-z0-9]+)*$#|unique:links,slug',
        ];
    }
}
