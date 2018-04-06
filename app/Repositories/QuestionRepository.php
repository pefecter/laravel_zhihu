<?php

namespace App\Repositories;

use App\Topic;
use App\Question;

/**
 * QuestionRepository class.
 */
class QuestionRepository
{
    /**
     * byIdWithTopicsAndAnswers function.
     *
     * @param [type] $id
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id', $id)->with('topics','answers')->first();
    }
 
    /**
     * create function.
     *
     * @param array $data
     */
    public function create(array $data)
    {
        return Question::create($data);
    }


    /**
     * byId function
     *
     * @param [type] $id
     * @return void
     */
    public function byId($id)
    {
        return Question::find($id);
    }

    /**
     * getQuestionFeed function
     *
     * @param [type] $id
     * @return void
     */
    public function getQuestionFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    /**
     * normalizeTopic function.
     *
     * @param [type] $topics
     *
     * @return array
     */
    public function normalizeTopic($topics)
    {
        return collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');

                return (int) $topic;
            }

            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);

            return $newTopic->id;
        })->toArray();
    }
}
