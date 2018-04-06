<?php

namespace App\Repositories;

use App\Message;



/**
 * MessageRepository class.
 */
class MessageRepository
{

    /**
     * create function.
     *
     * @param array $data
     */
    public function create(array $data)
    {
        return Message::create($data);
    }

}
