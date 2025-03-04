<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Exceptions\InputException;
use App\Services\Servicebase;
use Illuminate\Support\Facades\Hash;

class AuthService extends ServiceBase
{
    /**
     * Login
     *
     * @param array $data
     * @return array
     * @throws InputException
     */
    public function login(array $data)
    {
        $user = User::query()->where('email', '=', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new InputException('login_fail');
        }

        $token = $user->createToken('authUserToken')->plainTextToken;

        return [
            'access_token' => $token,
            'type_token' => 'Bearer',
            'message' => 'Login successfully',
        ];
    }

    /**
     * Register
     *
     * @param array $data
     * @return mixed
     * @throws InputException
     */
    public function register(array $data)
    {
        $newUser = User::query()->create([
            'name' => $data['name'],
            'email' => Str::lower($data['email']),
            'password' => Hash::make($data['password']),
        ]);

        if (!$newUser) {
            throw new InputException(trans('auth.register_fail'));
        }

        return $newUser;
    }

    /**
     * Update profile
     *
     * @param $data
     * @return int
     * @throws InputException
     */
    public function update($data)
    {
        $user = $this->user;
        if (!$user) {
            throw new InputException(trans('response.not_found'));
        }

        if ($user->status == User::STATUS_INACTIVE) {
            throw new InputException(trans('response.invalid'));
        }

        return User::query()
            ->where('id', '=', $user->id)
            ->update($data);
    }

    /**
     * Change Password
     *
     * @param array $data
     * @return bool
     * @throws InputException
     */
    public function changePassword(array $data)
    {
        $user = $this->user;

        if (!Hash::check($data['current_password'], $user->password)) {
            throw new InputException(trans('auth.password'));
        }

        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        return true;
    }
}
