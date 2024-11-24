<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_id' => ['required'],
            'image' => ['nullable'],
            'title' => ['required'],
            'content' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
