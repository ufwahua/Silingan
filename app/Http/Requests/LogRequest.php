<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
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
            'user_id' => ['required',Rule::exists('users', 'id')],
            'card_id' => ['required',Rule::exists('cards', 'id')],
            'log_type' => ['required'],
            'name' => ['sometimes'],  
            'plate_number' => ['sometimes'],
            'status'=> ['required'],
        ];
    }
}
