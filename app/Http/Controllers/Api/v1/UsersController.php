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
        return UsersResource::collection(User::all());
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
    public function update(UsersStoreRequest $request, User $users)
    {
        $users->update($request->validated());
        return new UsersResource($users);
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
