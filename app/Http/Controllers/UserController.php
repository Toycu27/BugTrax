<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserFileRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function storeAvatar(UserFileRequest $request): JsonResponse
    {
        $loggedInUser = $request->user();

        if ($request->hasFile('avatar')) {
            $uploadedFile = $request->file('avatar');
            $path = $request->file('avatar')->storeAs(
                'avatars',
                $request->user()->id . '.' .$uploadedFile->guessExtension(),
                'public'
            );
            if ($path) {
                $loggedInUser->avatar_path = $path; 
            }
        }

        $success = $loggedInUser->update();
        return $this->simpleResponse($success, 'Your Avatar has been updated.', $loggedInUser);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $loggedInUser = $request->user();

        if ($request->name) $loggedInUser->name = $request->name;
        if ($request->password) $loggedInUser->password = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            error_log("inside");
            $path = Storage::putFileAs(
                'avatars', $request->file('avatar'), $request->user()->id
            );
            if ($path) {
                $loggedInUser->avatar_path = $path; 
                error_log("path: " . $path);
            }
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
