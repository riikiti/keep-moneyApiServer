<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeStoreRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return IncomeResource::collection(Income::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeStoreRequest $request)
    {
        $created_income = Income::create($request->validated());

        return new Income($created_income);
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        return new  IncomeResource($income);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeStoreRequest $request, Income $income)
    {
        $income->update($request->validated());
        return new IncomeResource($income);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return response(null);
    }
}
