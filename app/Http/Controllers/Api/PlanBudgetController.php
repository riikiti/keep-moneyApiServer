<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanBudgetStoreRequest;
use App\Http\Resources\PlanBudgetResource;
use App\Models\PlanBudget;
use Illuminate\Http\Request;

class PlanBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PlanBudgetResource::collection(PlanBudget::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanBudgetStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new PlanBudgetResource(PlanBudget::findOrFail($id));
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
