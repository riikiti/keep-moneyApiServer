<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckStoreRequest;
use App\Http\Resources\CheckResource;
use App\Models\Check;

class CheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CheckResource::collection(Check::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckStoreRequest $request)
    {
        $created_check = Check::create($request->validated());

        return new CheckResource($created_check);
    }

    /**
     * Display the specified resource.
     */
    public function show(Check $check)
    {
        return new  CheckResource($check);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckStoreRequest $request, Check $check)
    {
        $check->update($request->validated());
        return new CheckResource($check);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Check $check)
    {
        $check->delete();

        return response(null);
    }
}
