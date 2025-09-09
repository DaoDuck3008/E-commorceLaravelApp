<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            //
            'name' => 'required|string',
            'category' => 'required|integer',
            'brand' => 'required|integer',
            'price' => 'required|integer|min: 1',
            'stockQuantity' => 'required|integer|min:1',
            'warrantyPeriod' => 'nullable',
            'description' => 'nullable|string',

            'version' => 'required|array|min:1',
            'version.*.name' => 'required|string',
            'version.*.price' => 'required|integer|min:1',

            'spec' => 'required|array|min:3', // phải là mảng và có ít nhất 3 phần tử
            'spec.*.key' => 'required|string',
            'spec.*.value' => 'required|string',

            'images'   => 'array',        // images phải là mảng
            'images.*' => 'image|max:5048', // từng phần tử trong mảng phải là ảnh

            'color' => 'nullable',
        ];
    }
}
