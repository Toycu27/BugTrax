<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function getUsers (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return User::latest('id')->with($withArr)->get();
    }

    public function getUser (Request $request, User $user) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $user->load($withArr);
    }
}
