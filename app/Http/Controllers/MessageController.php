<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repositories\MessageRepository;

class MessageController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    /**
     * store function
     * 发送私信
     */
    public function store()
    {
        $message = $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => Auth::guard('api')->user()->id,
            'body' => request('body'),
        ]);
        if ($message) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }
}
