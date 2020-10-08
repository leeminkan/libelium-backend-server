<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepository as UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model()
    {
        return User::class;
    }
}
