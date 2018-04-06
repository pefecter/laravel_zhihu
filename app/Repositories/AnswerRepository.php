<?php

namespace App\Repositories;

use App\Answer;



/**
 * AnswerRepository class.
 */
class AnswerRepository
{

    /**
     * create function.
     *
     * @param array $data
     */
    public function create(array $data)
    {
        return Answer::create($data);
    }

    /**
     * byId function.
     *
     * @param array $id
     */
    public function byId($id)
    {
        return Answer::find($id);
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
