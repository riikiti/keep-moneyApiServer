<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeStoreRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;

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
        return Income::create($request->validated());
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
