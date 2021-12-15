<?php

namespace App\Http\Requests\admin;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LotRequest extends FormRequest
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
            'block_id' =>['required',  Rule::exists('blocks', 'block_number')],
            'lot_number' => ['required','integer', 'max:255','gt:0'],
        ];
    }
}
