<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    /**
     * Method gets a random user id.
     *
     * @return int
     */
    public function getRandomUserId(): int
    {
        return User::all()->random()->id;
    }
}
