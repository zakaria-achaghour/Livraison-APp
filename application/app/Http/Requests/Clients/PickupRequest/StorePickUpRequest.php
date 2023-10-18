<?php

namespace App\Http\Requests\Clients\PickupRequest;

use Illuminate\Foundation\Http\FormRequest;

class StorePickUpRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'typeOfPickup' => 'required|string',
            'phone' => 'required',
            'city' => 'required',
            'note' => 'required|string',
            'address' => 'required|string'
        ];
    }
}
