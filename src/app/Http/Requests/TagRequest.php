<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vi_name' => 'required',
            'en_name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'vi_name' => __('custom.tag_vi_name'),
            'en_name' => __('custom.tag_en_name'),
        ];
    }
}
