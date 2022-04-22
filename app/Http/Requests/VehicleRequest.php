<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'image' => ['sometimes'],
            'user_id' => ['required',Rule::exists('users', 'id')],
            'type' => ['required'],
            'tag' => ['required'],
            'make' => ['required'],
            'model' => ['required'],
            'color' => ['required'],
            'plate_number' => ['required'],
        ];
    }
}
