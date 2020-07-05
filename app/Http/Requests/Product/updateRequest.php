<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest
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
            'product_updated' => 'boolean',
            'attributes_updated' => 'boolean',
            'thumbnail_updated' => 'boolean',
            'images_updated' => 'boolean',
            "name" => 'required_if:product_updated,1|min:5',
            "description" => 'required_if:product_updated,1|min:50',
            "stock" => 'required_if:product_updated,1|numeric|min:1',
            "price" => 'required_if:product_updated,1|numeric|min:1',
            "category_id" => "required_if:product_updated,1|exists:categories,id",
            "thumbnail" => "required_if:thumbnail_updated,1|image|mimes:jpeg,bmp,png,jpg",
            'images'   => 'required_if:images_updated,1|array|max:3',
            'images.*' => 'required_if:images_updated,1|image|mimes:jpeg,bmp,png,jpg',
            "attributes" => "required_if:attributes_updated,1|array",
            "attributes.*" => 'required_if:attributes_updated,1|exists:attributes,id'
        ];
    }
}
