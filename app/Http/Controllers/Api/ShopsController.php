<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopsStoreRequest;
use App\Http\Resources\ShopsResource;
use App\Models\Shops;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ShopsResource(Shops::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
