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
        $created_checkItem = CheckItem::create($request->validated());

        return new CheckItem($created_checkItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(CheckItem $checkItem)
    {
        return new  CheckItemResource($checkItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckItemStoreRequest $request,CheckItem $checkItem)
    {
        $checkItem->update($request->validated());
        return new CheckItemResource($checkItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CheckItem $checkItem)
    {
        $checkItem->delete();

        return response(null);
    }
}
