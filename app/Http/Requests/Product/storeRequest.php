<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
            "name" => 'required|min:5',
            "description" => 'required|min:50',
            "stock" => 'required|numeric|min:1',
            "price" => 'required|numeric|min:1',
            "thumbnail" => "required|image|mimes:jpeg,bmp,png,jpg",
            'images'   => 'required|array|max:3',
            'images.*' => 'required|image|mimes:jpeg,bmp,png,jpg',
            "category_id" => "required|exists:categories,id",
            "attributes" => "array" //TODO: Required
        ];
    }
}
