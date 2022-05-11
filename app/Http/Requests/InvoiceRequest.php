<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id_from'              => ['required', Rule::exists('users', 'id')],
            'collection_type_id'        => ['required', Rule::exists('collection_types','id')],
            'block_lot_id'              => ['required', Rule::exists('lots','id')],
            'due_date'                  => ['required'],
            'running_balance'           => ['required'],
            'over_due'                  => ['required'],
            'payment'                   => ['required'],
        ];
    }
}
