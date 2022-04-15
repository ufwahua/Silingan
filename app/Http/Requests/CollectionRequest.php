<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionRequest extends FormRequest
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
            'collection_type_id' => ['required', Rule::exists('collection_types','id')],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'block_lot_id' => ['required', Rule::exists('lots','id')],
            'amount' => ['required'],
            'notes' => ['sometimes'],
            'running_balance' => ['required']
        ];
    }
}
