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
            'user_login_id' => ['required',Rule::exists('users', 'id')],
            'user_logout_id' => ['sometimes',Rule::exists('users', 'id')],
            'card_id' => ['required',Rule::exists('cards', 'id')],
            'block_lot_id' => ['required',Rule::exists('lots', 'id')],
            'log_id' => ['required',Rule::exists('logs', 'id')],
            'log_type' => ['required'],
            'vehicle_label' => ['sometimes'],
            'vehicle_type' => ['sometimes'],
            'purpose_visit' => ['required'],
            'name' => ['sometimes'],  
            'plate_number' => ['sometimes'],
            'num_passenger' => ['sometimes'],

        ];
    }
}
