<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewUserFollowNotification;

class FollowersController extends Controller
{
    protected $user;

    /**
     * 依赖注入 function.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * index function
     * 是否关注该作者.
     */
    public function index($id)
    {
        $user = $this->user->byId($id);
        /**
         * user_id是存在于该用户关注中.
         */
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(Auth::guard('api')->user()->id, $followers)) {
            return response()->json(['followed' => true]);
        }

        return response()->json(['followed' => false]);
    }

    /**
     * follow function
     * 点击关注/取消关注该作者.
     */
    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));

        $followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);

        if (count($followed['attached']) > 0) {
            /*
             * 站内信息
             */
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');

            return response()->json(['followed' => true]);
        }

        $userToFollow->decrement('followers_count');

        return response()->json(['followed' => false]);
    }
}
