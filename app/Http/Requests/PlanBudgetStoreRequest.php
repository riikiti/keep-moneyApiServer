<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanBudgetStoreRequest extends FormRequest
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
            'budget_id'=>'required',
            'budget_on_start'=>'required',
            'user_id'=>'required',
            'value'=>'required',
            'period_start'=>'required|date',
            'period_finish'=>'required|date',
        ];
    }
}
