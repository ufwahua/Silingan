<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseRequest extends FormRequest
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
            'user_id' => ['required', Rule::exists('users', 'id')],
            'amount'=> ['required'],
            'notes'=> ['sometimes'],
            'official_receipt' => ['sometimes'],
            'running_balance' => ['required'],
            'fund_id' => ['required'],
            'expense_type_id' => ['required', Rule::exists('expense_types', 'id')]
        ];
    }
}
