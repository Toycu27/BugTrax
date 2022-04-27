<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class BugRequest extends FormRequest
{
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
            'Member' => ['GET', 'POST', 'PATCH'],
            'Client' => ['GET', 'POST'],
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
                    'project_id' => ['integer'],
                    'milestone_id' => ['integer'],
                    'created_by' => ['integer'],
                    'assigned_to' => ['integer'],
                    'status' => ['string', 'max:16'],
                    'title' => ['string', 'max:255'],
                    'desc' => ['string', 'max:255'],
                ];
            case 'POST':
                return [
                    'project_id' => ['required', 'integer', 'exists:projects,id'],
                    'milestone_id' => ['integer', 'exists:milestone,id'],
                    'assigned_to' => ['integer', 'exists:users,id'],
                    'published' => ['required', 'boolean'],
                    'status' => ['required', 'string', 'max:32'],
                    'priority' => ['required', 'string', 'max:32'],
                    'progress' => ['required', 'integer', 'between:0,100'],
                    'estimated_hours' => ['integer'],
                    'actual_hours' => ['integer'],
                    'title' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string', 'max:255'],
                    'reproduce_desc' => ['string', 'max:255'],
                    'solution_desc' => ['string', 'max:255'],
                    'url' => ['URL', 'max:255'],
                    'device_type' => ['string', 'max:32'],
                    'device_os' => ['string', 'max:32'],
                    'browser_info' => ['string', 'max:255'],
                    'tags' => ['json', 'max:255'],
                    'start_date' => ['date'],
                    'end_date' => ['date'],
                ];
            case 'PATCH':
                return [
                    'project_id' => ['integer', 'exists:projects,id'],
                    'milestone_id' => ['integer', 'exists:milestone,id'],
                    'assigned_to' => ['integer', 'exists:users,id'],
                    'published' => ['boolean'],
                    'status' => ['string', 'max:32'],
                    'priority' => ['string', 'max:32'],
                    'progress' => ['integer', 'between:0,100'],
                    'estimated_hours' => ['integer'],
                    'actual_hours' => ['integer'],
                    'title' => ['string', 'max:255'],
                    'desc' => ['string', 'max:255'],
                    'reproduce_desc' => ['string', 'max:255'],
                    'solution_desc' => ['string', 'max:255'],
                    'url' => ['URL', 'max:255'],
                    'device_type' => ['string', 'max:32'],
                    'device_os' => ['string', 'max:32'],
                    'browser_info' => ['string', 'max:255'],
                    'tags' => ['json', 'max:255'],
                    'start_date' => ['date'],
                    'end_date' => ['date'],
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
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'errors'      => $validator->errors()
        ]));
    }
}
