<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build Query
        $users = User::latest('id');

        //Filter Query
        $filters = $request->filter ? json_decode($request->filter) : null;
        if ($filters !== null) {
            if (isset($filters->name)) $users->where('name', 'like', '%' . $filters->name . '%');
            if (isset($filters->email)) $users->where('email', '=', $filters->email);
        }

        return $users->with($withArr)->paginate(10)->withQueryString();
    }

    public function getUser (Request $request, User $user) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $user->load($withArr);
    }
}
