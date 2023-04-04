<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesStoreRequest;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoriesResource::collection(Categories::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesStoreRequest $request)
    {
        $created_categories = Categories::create($request->validated());

        return new CategoriesResource($created_categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        return new CategoriesResource($categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesStoreRequest $request, Categories $categories)
    {
        $categories->update($request->validated());
        return new CategoriesResource($categories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        $categories->delete();

        return response(null);
    }
}
