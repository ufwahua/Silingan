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
            'first_name' => ['required','string' , 'max:255'],
            'last_name' => ['required','string' , 'max:255'],
            'gender' => ['required'],
            'block_number' => ['required'],
            'lot_number' => ['required'],
            'age' => ['required','integer','numeric','gt:0', 'max:150'],
            'contact_num' => ['required','string'],
            'email' => ['required','string' ,'email', 'max:255',Rule::unique('users')->ignore($this->route('user'))],
            'password' => ['required' , 'min:8'],
            'confirm_password' => ['required','same:password' , 'min:8'],
            'profile_pic'=> ['sometimes','required','blob'],
        ];
}
    
}
