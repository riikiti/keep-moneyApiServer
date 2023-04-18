<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesStoreRequest;
use App\Http\Resources\ExpensesResource;
use App\Models\Expenses;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ExpensesResource::collection(Expenses::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesStoreRequest $request)
    {
        return Expenses::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new ExpensesResource(Expenses::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesStoreRequest $request, Expenses $expenses)
    {
        $expenses->update($request->validated());
        return new ExpensesResource($expenses);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expenses)
    {
        $expenses->delete();

        return response(null);
    }
}
