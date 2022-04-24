<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'chat_room_id' => ['required',Rule::exists('chat_rooms', 'id')],
            'user_id' => ['required',Rule::exists('users', 'id')],
            'message' => ['required'],  
            'read' => ['required'],  
            
        ];
    }
}
