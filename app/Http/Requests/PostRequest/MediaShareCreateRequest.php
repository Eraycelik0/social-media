<?php

namespace App\Http\Requests\PostRequest;

use Illuminate\Foundation\Http\FormRequest;

class MediaShareCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'media_type' => 'required|in:Photo,Video',
            'media_url' => 'required|url',
        ];
    }
}
