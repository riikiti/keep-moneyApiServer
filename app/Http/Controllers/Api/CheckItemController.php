<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckItemStoreRequest;
use App\Http\Resources\CheckItemResource;
use App\Models\CheckItem;
use Illuminate\Http\Request;

class CheckItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CheckItemResource::collection(CheckItem::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckItemStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new  CheckItemResource(CheckItem::findOrFail($id));
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
