<?php

namespace App\Http\Requests\Clients\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'fullName' => 'required|string',
            'cine' => '',
            'email' => 'required|email|unique:App\Models\Customer,customers_email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'storeName' => 'required|string',
            'companyType' => 'required',
            'siteWeb' => '',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required|string'
        ];
    }
}
