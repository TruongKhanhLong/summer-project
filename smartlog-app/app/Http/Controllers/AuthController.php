<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\RateLimiter;
class AuthController extends Controller
{
    public const MAX_ATTEMPTS_LOGIN = 5;
    public const DECAY_SECONDS = 45;

    public function login(LoginRequest $request): JsonResponse
    {
        $ip = $request->ip();
        $inputs = $request->only(['email', 'password']);
        $key = Str::lower($inputs['email'] . '|user_login|' . $ip);
        if ($this->tooManyAttempts($key, self::MAX_ATTEMPTS_LOGIN)) {
            return $this->sendLockoutResponse($key);
        }

        $loginData = AuthService::getInstance()->login($inputs);
        if ($loginData) {
            $this->clearLoginAttempts($key);

            return $this->sendSuccessResponse($loginData);
        }

        $this->incrementAttempts($key, self::DECAY_SECONDS);
        if ($this->retriesLeft($key, self::MAX_ATTEMPTS_LOGIN) == 0) {
            throw new \Exception(trans('auth.throttle', ['seconds' => self::DECAY_SECONDS]));
        }

        return $this->sendFailedLoginResponse();
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    protected function sendSuccessResponse(array $data): JsonResponse
    {
        return response()->json($data);
    }

    protected function sendFailedLoginResponse(): JsonResponse
    {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    protected function sendLockoutResponse(string $key): JsonResponse
    {
        $seconds = $this->availableIn($key);

        return response()->json(['message' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.'], 429);
    }

    protected function tooManyAttempts($key, $maxAttempts)
    {
        return RateLimiter::tooManyAttempts($key, $maxAttempts);
    }
    
    protected function clearLoginAttempts($key)
    {
        RateLimiter::clear($key);
    }

    public function register(Request $request): JsonResponse
    {
        $inputs = $request->only(['name', 'email', 'password']);
        $user = AuthService::getInstance()->register($inputs);

        return response()->json($user);
    }
}
