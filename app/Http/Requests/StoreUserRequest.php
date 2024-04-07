<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'email'=> ['required', 'string', 'max:100', 'unique:users'],
            'phone'=> ['string', 'max:11', 'unique:users'],
            'password'=> ['required', 'confirmed', Password::defaults()]
        ];
    }
}
