<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function show (UserRequest $request, User $user) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($user->load($withArr), 200);
    }

    public function index (UserRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $users = User::latest('id');
        if ($request->name ?? false) $users->where('name', 'like', '%' . $request->name . '%');
        if ($request->email ?? false) $users->where('email', '=', $request->email);

        return $users->with($withArr)->paginate(10)->withQueryString();
    }

    public function delete (UserRequest $request, User $user) {
        $user->destroy($user->id);

        return response()->json(null, 204);
    }
}
