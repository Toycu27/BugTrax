<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        return true;
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
                    'desc' =>  ['string', 'max:255'],
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
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
