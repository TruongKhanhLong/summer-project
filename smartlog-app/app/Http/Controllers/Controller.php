<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\StatefulGuard;

abstract class Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return string
     */
    protected function getGuard(): string
    {
        return property_exists($this, 'guard') ? $this->guard : config('auth.defaults.guard');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard($this->getGuard());
    }

    /**
     * Send Error Response
     *
     * @param string $message
     * @param  $errors
     * @param  $data
     * @param int $code
     * @return JsonResponse
     */
    protected function sendErrorResponse(string $message, $errors = null, $data = null, int $code = ResponseHelper::STATUS_CODE_BAD_REQUEST): JsonResponse
    {
        return ResponseHelper::sendResponse($code, $message, $data, $errors);
    }

    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function sendSuccessResponse($data, string $message = '', int $code = ResponseHelper::STATUS_CODE_SUCCESS): JsonResponse
    {
        return ResponseHelper::sendResponse($code, $message, $data);
    }

    protected function getTableParams($request): array
    {
        return [
            $request->get('search'),
            $request->get('orders'),
            $request->all(),
            $request->get('per_page'),
        ];
    }
}
