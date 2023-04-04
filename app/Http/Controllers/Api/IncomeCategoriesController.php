<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeCategoriesStoreRequest;
use App\Http\Resources\IncomeCategoriesResource;
use App\Models\IncomeCategories;
use Illuminate\Http\Request;

class IncomeCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return IncomeCategoriesResource::collection(IncomeCategories::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeCategoriesStoreRequest $request)
    {
        $created_incomeCategories = IncomeCategories::create($request->validated());

        return new IncomeCategories($created_incomeCategories);
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomeCategories $incomeCategories)
    {
        return new  IncomeCategoriesResource($incomeCategories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeCategoriesStoreRequest $request, IncomeCategories $incomeCategories)
    {
        $incomeCategories->update($request->validated());
        return new IncomeCategoriesResource($incomeCategories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomeCategories $incomeCategories)
    {
        $incomeCategories->delete();

        return response(null);
    }
}
