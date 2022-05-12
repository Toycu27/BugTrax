<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use JsonResponseTrait;

    public function show(UserRequest $request, User $user): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $this->simpleResponse(true, null, $user->load($withArr));
    }

    public function index(UserRequest $request): JsonResponse
    {
        $users = User::latest('id');

        if ($request->name ?? false) $users->where('name', 'like', '%' . $request->name . '%');
        if ($request->email ?? false) $users->where('email', '=', $request->email);
        
        if ($request->with ?? false) $users->with(explode(',', $request->with));

        if ($request->paginate ?? false) 
            return $this->ResponseWithPagination(true, null, $users->paginate($request->paginate)->withQueryString());
        else 
            return $this->simpleResponse(true, null, $users->get());
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $loggedInUser = $request->user();
        $loggedInUser->name = $request->name;
        if ($request->password) {
            $loggedInUser->password = Hash::make($request->password);
        }
        $success = $loggedInUser->update();

        return $this->simpleResponse($success, 'Your Account information has been updated.', $loggedInUser);
    }

    public function destroy(UserRequest $request, User $user): JsonResponse
    {
        $user->destroy($user->id);

        return $this->simpleResponse(true, 'Your Account has been deleted.');
    }
}
