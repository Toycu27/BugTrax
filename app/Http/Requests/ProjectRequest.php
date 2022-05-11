<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\JsonResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProjectRequest extends FormRequest
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
            'Member' => ['GET'],
            'Client' => ['GET'],
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
                    'title' => ['string', 'max:255'],
                    'desc' => ['string', 'max:255'],
                ];
            case 'POST':
                return [
                    'title' => ['required', 'string', 'unique:projects', 'max:255'],
                    'desc' => ['required', 'string', 'max:255'],
                ];
            case 'PATCH':
                return [
                    'title' => ['string', 'max:255'],
                    'desc' => ['string', 'max:255'],
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
