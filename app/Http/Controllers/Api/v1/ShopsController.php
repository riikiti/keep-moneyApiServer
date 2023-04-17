<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopsStoreRequest;
use App\Http\Resources\ShopsResource;
use App\Models\Shops;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ShopsResource::collection(Shops::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopsStoreRequest $request)
    {
        return Shops::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Shops $shops)
    {
        return new ShopsResource($shops);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopsStoreRequest $request, Shops $shops)
    {
        $shops->update($request->validated());
        return new ShopsResource($shops);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shops $shops)
    {
        $shops->delete();

        return response(null);
    }
}
