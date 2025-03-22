<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'value' => ['required', 'numeric', 'min:0', 'max:1000000'],
            'currency' => ['required', 'string', 'size:3'],
            'method' => ['required', 'string', 'in:credit_card,paypal'],
            'gateway' => ['required', 'string', 'max:255'],
            'success_url' => ['required', 'url', 'max:255'],
            'cancel_url' => ['required', 'url', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'gateway_reference' => ['nullable', 'string', 'max:255'],
            'promo_code' => ['nullable', 'string', 'max:255'],
            'itinerary_uid' => ['required', 'string', 'max:255'],
            'product_uid' => ['required', 'string', 'max:255'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
