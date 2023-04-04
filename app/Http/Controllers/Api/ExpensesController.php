<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesStoreRequest;
use App\Http\Resources\ExpensesResource;
use App\Models\Expenses;
use Illuminate\Http\Request;

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
        $created_expenses = Expenses::create($request->validated());

        return new Expenses($created_expenses);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        return new  ExpensesResource($expenses);
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
