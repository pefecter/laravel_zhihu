<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repositories\AnswerRepository;

class VotesController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /**
     * users function
     * 该用户是否点赞过答案.
     *
     * @param [type] $id
     */
    public function users($id)
    {
        $user = Auth::guard('api')->user();
        if ($user->hasVotedFor($id)) {
            return  response()->json(['voted' => true]);
        }

        return  response()->json(['voted' => false]);
    }

    /**
     * vote function
     * 点赞该问题.
     */
    public function vote()
    {
        $answer = $this->answer->byId(request('answer'));

        $voted = Auth::guard('api')->user()->voteFor(request('answer'));

        if (count($voted['attached']) > 0) {
            $answer->increment('votes_count');

            return response()->json(['voted' => true]);
        }

        $answer->decrement('votes_count');

        return response()->json(['voted' => false]);
    }
}
