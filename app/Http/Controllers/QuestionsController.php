<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\QuestionRepository;
use App\Http\Requests\StoreQuestionRequest;

class QuestionsController extends Controller
{
    protected $questionRepository;

    /**
     * 登录才能发布问题.
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        //普通验证方法
        // $rules = [
        //     'title' => 'required|min:6|max:196',
        //     'body' => 'required|min:26',
        // ];

        // $message = [
        //     'title.required' => '标题不能为空',
        //     'title.min' => '标题不能少于6个字符',
        //     'body.required' => '内容不能为空',
        //     'body.min' => '内容不能少于26个字符',
        // ];

        // $this->validate($request,$rules,$message);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];

        $question = $this->questionRepository->create($data);

        /*
         * 添加在关联表
         */
        $question->topics()->attach($topics);

        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        /**
         * 判断是否为本人
         */
        if (Auth::user()->owns($question)) {
            return view('questions.edit', compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body')
        ]);

         /*
         * 添加在关联表
         */
       
        $question->topics()->sync($topics);

        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);

        if (Auth::user()->owns($question)) {
            $question->delete();

            return redirect('/');
        }
        about(403,'Forbidden'); //return back();
    }

    /*
     * store中的自定义方法.
     *
     * @param array $topics
     */
    // public function normalizeTopic(array $topics)
    // {
    //     return collect($topics)->map(function ($topic) {
    //         if (is_numeric($topic)) {
    //             Topic::find($topic)->increment('questions_count');

    //             return (int) $topic;
    //         }

    //         $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);

    //         return $newTopic->id;
    //     })->toArray();
    // }
}
