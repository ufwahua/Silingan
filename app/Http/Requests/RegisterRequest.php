<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'block_lot_id'          => ['required',Rule::exists('lots', 'id')],
            'email'                 => ['required','string' ,'email', 'max:255',Rule::unique('users')->ignore($this->route('user'))],
            'password'              => ['required' , 'min:8'],
             'confirm_password'     => ['required','same:password' , 'min:8'],
            'first_name'            => ['required','string' , 'max:255'],
            'last_name'             => ['required','string' , 'max:255'],
            'gender'                => ['required'],
            'age'                   => ['required','integer','numeric','gt:0', 'max:130'],
            'contact_num'           => ['required','string','min:11'],
            'profile_pic'           => ['sometimes'],
            'has_voted'             => ['required'],
            'verified'              => ['required'],
            'status'                => ['required'],
            'role'                  => ['required'],
            'position_id'           => ['sometimes'],
           
        ];

}
    
}
