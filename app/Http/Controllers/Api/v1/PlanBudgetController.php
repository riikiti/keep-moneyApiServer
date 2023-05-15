<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanBudgetStoreRequest;
use App\Http\Resources\PlanBudgetResource;
use App\Models\PlanBudget;

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
        return PlanBudget::create($request->validated());
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
            $finish = date('Y-m-d H:i:s', strtotime('+3 hours'));
        } else {
            $finish = $_GET['finish'];
        }
        if (empty($_GET['per_page'])) {
            $per_page = 10;
        } else {
            $per_page = $_GET['per_page'];
        }
        return PlanBudgetResource::collection(PlanBudget::where('user_id', $id)
            ->where('period_start', '>=', $start)
            ->where('period_finish', '<=', $finish)
            ->paginate($per_page));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanBudgetStoreRequest $request, $id)
    {
        $planBudget = PlanBudget::findOrFail($id);
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
