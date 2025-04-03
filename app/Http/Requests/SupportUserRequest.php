<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'email' => ['required', 'email'],
			'name' => ['required', 'string', 'max:256'],
            'content' => ['required', 'string', 'max:1024'],
            'title' => ['nullable', 'string', 'max:256']
        ];
    }
}
