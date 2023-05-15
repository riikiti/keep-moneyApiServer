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
    public function show($id)
    {
        if (empty($_GET['start'])) {
            $start = "1970-01-01 00:00:00";
        } else {
            $start = $_GET['start'];
        }
        if (empty($_GET['finish'])) {
            $finish = date('Y-m-d H:i:s',strtotime('+3 hours'));
        } else {
            $finish = $_GET['finish'];
        }
        if (empty($_GET['per_page'])) {
            $per_page = 10;
        } else {
            $per_page = $_GET['per_page'];
        }
        return  IncomeResource::collection(Income::where('user_id',$id)
            ->where('date', '>=', $start)
            ->where('date', '<=', $finish)
            ->paginate($per_page));
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
