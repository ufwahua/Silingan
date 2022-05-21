<?php

namespace App\Http\Requests;


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
            'block_id' =>['required'],

            'number' => ['required','integer','unique:lots,block_id,' . $this->route('lot')],
            'active' => ['required']
        ];
        // return [
        //     'block_id' =>['required'],

        //     'number' => ['required','integer','unique:lots,block_id,' . $this->route('lot')],
        //     'active' => ['required']
        // ];
    }
}
