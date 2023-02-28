<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'company_id' => ['required'],
            'price' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:1'],
            'comment' => ['required', 'string', 'max:1000'],
            'img_path' => ['nullable'],
        ];
    }
}
