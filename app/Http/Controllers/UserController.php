<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserGetRequest;

class UserController extends Controller
{
    public function getUsers (UserGetRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $users = User::latest('id');
        if ($request->name ?? false) $users->where('name', 'like', '%' . $request->name . '%');
        if ($request->email ?? false) $users->where('email', '=', $request->email);

        return $users->with($withArr)->paginate(10)->withQueryString();
    }

    public function getUser (Request $request, User $user) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $user->load($withArr);
    }
}
