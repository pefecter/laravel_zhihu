<?php

namespace App\Repositories;

use App\User;


/**
 * UserRepository class.
 */
class UserRepository
{

    /**
     * byId function.
     *
     * @param  $id
     */
    public function byId($id)
    {
        return User::find($id);
    }


}
