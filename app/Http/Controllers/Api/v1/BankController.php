<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankStoreRequest;
use App\Http\Resources\BankResource;
use App\Models\Bank;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BankResource::collection(Bank::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankStoreRequest $request)
    {
        return Bank::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $Bank)
    {
        return new BankResource($Bank);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankStoreRequest $request, Bank $Bank)
    {
        $Bank->update($request->validated());
        return new BankResource($Bank);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $Bank)
    {
        $Bank->delete();

        return response(null);
    }
}
