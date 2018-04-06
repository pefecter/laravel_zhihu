<?php

use App\Topic;
use App\Follow;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * ajax请求话题选择器
 */
Route::middleware('api')->get('/topics', function (Request $request) {
    $topics = Topic::select(['id', 'name'])
            ->where('name', 'like', '%'.$request->query('q').'%')
            ->get();

    return $topics;
});

/*
 * 是否关注该问题
 */
Route::middleware('auth:api')->post('/question/follower', function (Request $request) {
    $user = Auth::guard('api')->user();
    $followed = $user->followed($request->get('question'));
    if ($followed) {
        return response()->json(['followed' => true]);
    }
});

/*
 * 点击关注/取消关注该问题
 */
Route::middleware('auth:api')->post('/question/follow', function (Request $request) {
    $user = Auth::guard('api')->user();
    $question = Question::find($request->get('question'));
    $followed = $user->followThis($question->id);
    
    if (count($followed['detached']) > 0) {
        $question->decrement('followers_count');

        return response()->json(['followed' => false]);
    }
    
    $question->increment('followers_count');

    return response()->json(['followed' => true]);
});

/*
 * 是否关注Ta
 */
Route::get('/user/followers/{id}', 'FollowersController@index');

/*
 * 点击关注Ta
 */
Route::post('/user/follow', 'FollowersController@follow');

/*
 * 是否点赞过该答案
 */
Route::post('/answer/{id}/votes/user', 'VotesController@users');

/*
 * 点赞该答案
 */
Route::post('/answer/vote', 'VotesController@vote');

/*
 * 发送私信
 */
Route::post('/message/store', 'MessageController@store');