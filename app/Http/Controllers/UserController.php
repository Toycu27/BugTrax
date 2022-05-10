<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(UserRequest $request, User $user): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($user->load($withArr), 200);
    }

    public function index(UserRequest $request): JsonResponse
    {
        $users = User::latest('id');

        if ($request->name ?? false) $users->where('name', 'like', '%' . $request->name . '%');
        if ($request->email ?? false) $users->where('email', '=', $request->email);
        
        if ($request->with ?? false) $users->with(explode(',', $request->with));

        if ($request->paginate ?? false) return response()->json(
            $users->paginate($request->paginate)->withQueryString(),
            200
        );
        else return response()->json([
            'data' => $users->get()
        ], 200);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $loggedInUser = $request->user();
        $loggedInUser->name = $request->name;
        $loggedInUser->password = Hash::make($request->password);
        $loggedInUser->update();

        return response()->json([
            'success' => true,
            'data' => $loggedInUser,
            'message' => 'Your Account information has been updated.',
        ], 200);
    }

    public function destroy(UserRequest $request, User $user): JsonResponse
    {
        $user->destroy($user->id);

        return response()->json(null, 204);
        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Your Account has been deleted.',
        ], 204);
    }
}
