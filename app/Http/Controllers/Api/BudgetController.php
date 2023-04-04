<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetStoreRequest;
use App\Http\Resources\BudgetResource;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BudgetResource::collection(Budget::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetStoreRequest $request)
    {
        $created_budget = Budget::create($request->all());

        return new BudgetResource($created_budget);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       return new BudgetResource(Budget::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
