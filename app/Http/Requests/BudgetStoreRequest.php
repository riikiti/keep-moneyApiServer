<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'bank'=>'required|max:255',
            'type'=>'required|max:255',
            'user_id'=>'required',
            'numbers'=>'required|max:4',
            'budget'=>'required',
            'last_date'=>'required|max:4',
        ];
    }
}
