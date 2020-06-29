<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'required|min:6',
            "email" => "required|email",
            "password" => "required|min:8|confirmed",
            "number" => "required|numeric|min:11",
            "address" => "required|min:10",
            "gender" => "required|in:male,female",
            "image" => "image|mimes:jpeg,bmp,png,jpg"
        ];
    }
}
