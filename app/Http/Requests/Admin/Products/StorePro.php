<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StorePro extends FormRequest
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
            'title' => 'required|min:4|max:245',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'thumbnail_url' => 'required|mimes:gif,jpg,jpeg,png',
            'source_url' => 'required|mimes:gif,jpg,jpeg,png',
            'demo_url' => 'required|mimes:gif,jpg,jpeg,png'
        ];
    }
}
