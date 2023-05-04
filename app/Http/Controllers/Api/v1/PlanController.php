<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanStoreRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PlanResource::collection(Plan::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanStoreRequest $request)
    {
        return Plan::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return PlanResource::collection(Plan::all()->where('user_id',$id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->validated());
        return new PlanResource($plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response(null);
    }
}
