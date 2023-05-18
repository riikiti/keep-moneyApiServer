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
        if (empty($_GET['category'])) {
            $category = '%';
        } else {
            $category = $_GET['category'];
        }
        if (empty($_GET['per_page'])) {
            $per_page = 1000;
        } else {
            $per_page = $_GET['per_page'];
        }
        return ExpensesResource::collection(Expenses::where('user_id', $id)
            ->where('categories_id', 'LIKE', $category)
            ->where('date', '>=', $start)
            ->where('date', '<', $finish)
            ->paginate($per_page));
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
