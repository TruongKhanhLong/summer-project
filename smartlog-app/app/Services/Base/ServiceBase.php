<?php

namespace App\Services;

use App\Models\User;

abstract class ServiceBase
{
    /**
     * @var null|User
     */
    protected $user = null;

    /**
     * @param User|null $user
     * @return $this
     */
    public function withUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): User|null
    {
        return $this->user;
    }

    /**
     * Create new service instance
     *
     * @return $this
     */
    public static function getInstance()
    {
        return app(static::class);
    }
}
