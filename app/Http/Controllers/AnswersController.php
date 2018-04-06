<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AnswerRepository;
use App\Http\Requests\StoreAnsweRequest;

class AnswersController extends Controller
{
    protected $answer;

    /**
     * 登录才能回答问题.
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnsweRequest $request, $question)
    {
        $answer = $this->answer->create([
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body'),
        ]);

        $answer->question()->increment('answers_count');

        return back();
    }
}
