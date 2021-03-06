<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'from_user_id'   => ['required', Rule::exists('users', 'id')], 
            'to_user_id'   => ['required', Rule::exists('users', 'id')], 
               
            'chat_room_id'   => ['sometimes'],
            'post_id'   => ['sometimes'],
            'election_id'   => ['sometimes'],
            'announcement_id'   => ['sometimes'],
            
            'message'   => ['required', 'max:255'],
        ];
    }
}
