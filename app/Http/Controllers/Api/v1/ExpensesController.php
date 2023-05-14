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
        $start = $_GET['start'];
        $finish= $_GET['finish'];
        return ExpensesResource::collection(Expenses::where('user_id', $id)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->paginate(5));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesStoreRequest $request, $id)
    {
        $expenses = Expenses::findOrFail($id);
        $expenses->update($request->validated());
        return new ExpensesResource($expenses);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expenses = Expenses::findOrFail($id);
        $expenses->delete();

        return response(null);
    }
}
