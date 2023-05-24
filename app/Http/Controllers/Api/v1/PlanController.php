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
        if (empty($_GET['start'])) {
            $start = "1970-01-01 00:00:00";
        } else {
            $start = $_GET['start'];
        }
        if (empty($_GET['finish'])) {
            $finish = "2070-01-01 00:00:00";
        } else {
            $finish = $_GET['finish'];
        }
        if (empty($_GET['per_page'])) {
            $per_page = 10;
        } else {
            $per_page = $_GET['per_page'];
        }
        return PlanResource::collection(Plan::where('user_id', $id)
            ->where('period_start', '>=', $start)
            ->where('period_finish', '<=', $finish)
            ->paginate($per_page));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanStoreRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);
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
