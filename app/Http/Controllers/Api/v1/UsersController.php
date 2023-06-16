<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty($_GET['per_page'])) {
            $per_page = 100000;
        } else {
            $per_page = $_GET['per_page'];
        }
        return UsersResource::collection(User::where('id',"!=",null)
            ->paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersStoreRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $created_users = User::create($validatedData);

        return new User($created_users);
    }

    /**
     * Display the specified resource.
     */
    public function show($email)
    {
        return User::where('email',$email) -> first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersStoreRequest $request, $id)
    {
        $expenses = User::findOrFail($id);
        $expenses->update($request->validated());
        return new  UsersResource($expenses);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null);
    }
}
