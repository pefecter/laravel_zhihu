<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class QuestionFollowController extends Controller
{
    /**
     * 需要登录才可以访问控制器方法.
     *
     * @param [type] $question
     */
    public function __construct($question)
    {
        $this->middleware('auth');
    }

    /**
     * followThis function
     * 关注问题.
     *
     * @param [type] $question
     */
    public function follow($question)
    {
        Auth::user()->followThis($question);

        return back();
    }
}
