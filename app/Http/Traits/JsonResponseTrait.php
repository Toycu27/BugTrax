<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonResponseTrait
{
    public function simpleResponse (bool $success, string $message = null, $data = null, $errors = null, $httpCode = 200): JsonResponse
    {
        if ($success === false) {
            return $this->errorResponse(null, $errors);
        }

        $responseArr = [
            'success' => true,
            'data' => $data,
            'errors' => $errors,
            'message' => $message,
        ];

        return response()->json($responseArr, $httpCode);
    }

    public function ResponseWithPagination (bool $success, string $message = null, $data = null, $errors = null, $httpCode = 200): JsonResponse
    {
        if ($success === false) {
            return $this->errorResponse(null, $errors);
        }

        $data = $data->toArray();
        $data['success'] = true;
        $data['errors'] = $errors;
        $data['message'] = $message;

        return response()->json($data, $httpCode);
    }

    public function validationResponse($errors = null) {
        $responseArr = [
            'success' => false,
            'data' => null,
            'errors' => $errors,
            'message' => null,
        ];

        return response()->json($responseArr, 400);
    }

    public function authResponse() {
        $responseArr = [
            'success' => false,
            'data' => null,
            'errors' => null,
            'message' => 'You dont have permission for this action!',
        ];

        return response()->json($responseArr, 403);
    }

    public function errorResponse ($message = null, $errors = null): JsonResponse {
        if ($message === null) $message = "Unknwon Internal Server Error";

        $responseArr = [
            'success' => false,
            'data' => null,
            'errors' => $errors,
            'message' => $message,
        ];

        throw new HttpResponseException(
            response()->json($responseArr, 400)
        );
    }
}