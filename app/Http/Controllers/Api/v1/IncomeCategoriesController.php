<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeCategoriesStoreRequest;
use App\Http\Resources\IncomeCategoriesResource;
use App\Models\IncomeCategories;

class IncomeCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty($_GET['per_page'])) {
            $per_page = 10;
        } else {
            $per_page = $_GET['per_page'];
        }
        return IncomeCategoriesResource::collection(IncomeCategories::where('id',"!=",null)
            ->paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeCategoriesStoreRequest $request)
    {
        return IncomeCategories::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (empty($_GET['per_page'])) {
            $per_page = 1000;
        } else {
            $per_page = $_GET['per_page'];
        }
        return IncomeCategoriesResource::collection(IncomeCategories::where('id',"!=",null)
            ->paginate($per_page));
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
    public function destroy($id)
    {
        $incomeCategories=IncomeCategories::findOrFail($id);;
        $incomeCategories->delete();

        return response(null);
    }
}
