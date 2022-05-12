<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\JsonResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    use JsonResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $user_role = auth()->user()->role;

        $perms = [
            'Admin' => ['GET', 'POST', 'PATCH', 'DELETE'],
            'Manager' => ['GET', 'POST', 'PATCH', 'DELETE'],
            'Member' => ['GET', 'POST', 'PATCH', 'DELETE'],
            'Client' => ['GET', 'POST', 'PATCH', 'DELETE'],
        ];

        if (in_array($request->method(), $perms[$user_role])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return [
                    'name' => ['string', 'max:255'],
                    'email' => ['email', 'max:255'],
                    'role' => ['string', 'max:32'],
                ];
            case 'POST':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users', 'max:255'],
                ];
            case 'PATCH':
                return [
                    'name' => ['string', 'max:255'],
                    'email' => ['email', 'unique:users', 'max:255'],
                    'password_current' => ['current_password'],
                    'password' => ['nullable', 'string', 'max:255'],
                    'password_confirm' => ['same:password'],
                    'role' => ['nullable', 'string', 'max:32'],
                ];
            case 'DELETE':
                return [];
        }
    }

    /**
     * Throw exception if validation failes
     *
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->simpleResponse(false, null, null, $validator->errors())
        );
    }
}
