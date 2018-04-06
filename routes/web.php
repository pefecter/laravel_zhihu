<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 发送注册邮件
Route::get('email/verify/{token}', ['as' => 'email.verify','uses' => 'EmailController@verify']);

//发布问题
Route::resource('questions', 'QuestionsController',['names'=>[
    'create' => 'question.create',
    'show' => 'question.show',
]]);


Route::post('questions/{question}/answer','AnswersController@store');

Route::get('questions/{question}/follow','QuestionFollowController@follow');

//站内信息
Route::get('notifications','NotificationsController@index');
