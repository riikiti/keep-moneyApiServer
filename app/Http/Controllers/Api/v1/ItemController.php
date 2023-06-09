<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ItemResource::collection(Item::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request)
    {
        return  Item::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return new  ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemStoreRequest $request, Item $item)
    {
        $item->update($request->validated());
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response(null);
    }
}
