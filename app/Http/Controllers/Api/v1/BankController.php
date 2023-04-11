<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankStoreRequest;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $Bank = BankResource::collection(Bank::all());


        if ($Bank->count() > 0) {
            $data = [
                'status' => 200,
                'data' => $Bank
            ];
        } else {
            $data = [
                'status' => 404,
                'msg' => 'no record found'
            ];
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankStoreRequest $request)
    {
        $created_Bank = Bank::create($request->validated());

        return new BankResource($created_Bank);
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
