<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestProductRequest extends FormRequest
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
          'category_id' => 'required',
          'name' => 'required|unique:products',
          'price' => 'required|numeric',
          'amount_of' => 'required|numeric',
          'content' => 'required',
          'images' => 'required',
        ];
    }
}
