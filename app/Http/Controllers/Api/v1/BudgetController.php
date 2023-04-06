<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetStoreRequest;
use App\Http\Resources\BudgetResource;
use App\Models\Budget;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budget = BudgetResource::collection(Budget::all());


        if ($budget->count() > 0) {
            $data = [
                'status' => 200,
                'data' => $budget
            ];
        } else {
            $data = [
                'status' => 404,
                'msg' => 'no record found'
            ];
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetStoreRequest $request)
    {
        $created_budget = Budget::create($request->validated());

        return new BudgetResource($created_budget);
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        return new BudgetResource($budget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetStoreRequest $request, Budget $budget)
    {
        $budget->update($request->validated());
        return new BudgetResource($budget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();

        return response(null);
    }
}