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
        $created_planBudget = PlanBudget::create($request->validated());

        return new PlanBudget($created_planBudget);
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanBudget $planBudget)
    {
        return new PlanBudgetResource($planBudget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanBudgetStoreRequest $request, PlanBudget $planBudget)
    {
        $planBudget->update($request->validated());
        return new PlanBudgetResource($planBudget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanBudget $planBudget)
    {
        $planBudget->delete();

        return response(null);
    }
}
