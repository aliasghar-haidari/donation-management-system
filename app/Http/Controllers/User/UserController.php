<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();
        $perPage = $request->perPage ?? 10;
        $sortBy = $request->sortBy ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);
        return UserResource::collection($query->paginate($perPage));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json([
            'message' => 'User created successfully.',
            'data' => new UserResource($user)
        ], 201);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json([
            'message' => 'User updated successfully.',
            'data' => new UserResource($user)
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully.'
        ], 204);
    }
}