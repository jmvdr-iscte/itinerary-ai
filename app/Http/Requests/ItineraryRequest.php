<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Itinerary\Transportation as ETransportation;
use App\Enums\Itinerary\Category as ECategory;

class ItineraryRequest extends FormRequest
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
			'categories' => ['required', 'array', 'min:1'],
			'email' => ['required', 'email'],
			'categories.*' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, ECategory::cases()))],
			'transportation' => ['required', 'array', 'min:1'],
			'transportation.*' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, ETransportation::cases()))],
			'destination' => ['required', 'string', 'max:255'],
			'number_of_people' => ['required', 'integer', 'min:1'],
			'origin' => ['required', 'string', 'max:255'],
			'from' => ['required', 'date', 'date_format:Y-m-d\TH:i:sP'],
			'to' => ['required', 'date', 'date_format:Y-m-d\TH:i:sP', 'after:from'],
		];
	}
}
