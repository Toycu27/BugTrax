<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserGetRequest;

class UserController extends Controller
{
    public function index (UserGetRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $users = User::latest('id');
        if ($request->name ?? false) $users->where('name', 'like', '%' . $request->name . '%');
        if ($request->email ?? false) $users->where('email', '=', $request->email);

        return $users->with($withArr)->paginate(10)->withQueryString();
    }

    public function show (Request $request, User $user) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($user->load($withArr), 200);
    }

    public function update (Request $request, User $user) {
        $user->update($request->all());
    
        return response()->json($user, 200);
    }

    public function delete (Request $request, User $user) {
        $user->destroy($user->id);

        return response()->json(null, 204);
    }
}
