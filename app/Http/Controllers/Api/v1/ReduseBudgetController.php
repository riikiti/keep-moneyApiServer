<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetResource;
use App\Models\Budget;
use Illuminate\Http\Request;

class ReduseBudgetController extends Controller
{
    public function update(Request $request,$id)
    {
        $budget = Budget::find($id);
        $budget->budget -= $request->input('update_budget');;
        $budget->save();
        return new BudgetResource($budget);
    }
}
