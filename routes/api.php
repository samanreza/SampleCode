<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RemoveBadWordsController;
use App\Http\Controllers\AllocatedBonusForUser;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function () {
    Route::post('login', [UserController::class,'login']);
});

/**
 * Admin
 */
Route::group([
    'middleware' => ['api','auth:api','can:admin'],
    'prefix' => 'get-users'
], function(){
    //Users All List For Admin
    Route::get('list',[UserController::class,'index']);
});

Route::group([
    'middleware' => ['api','auth:api','can:admin'],
    'prefix' => 'task'
], function(){
    //All Task List
    Route::get('list',[TaskController::class,'index']);
    //Update Task
    Route::patch('edit/{tasks}',[TaskController::class,'update']);
    //Delete Task
    Route::delete('remove/{tasks}',[TaskController::class,'destroy']);
    //Admin Mention Himself To The Task
    Route::post('additional-mention/{tasks}',[TaskController::class,'mentionInTask']);
    //Admin Can Mention Any Users To Any Task
    Route::post('definition-task',[TaskController::class,'defineTaskForUsers']);

});

Route::group([
    'middleware' => ['api','auth:api','can:admin'],
    'prefix' => 'check_tasks'
], function(){
    //bad words will be banned
    Route::post('title',[RemoveBadWordsController::class,'create']);
});

Route::group([
    'middleware' => ['api','auth:api','can:admin'],
    'prefix' => 'task'
], function(){
    //Filter Task
    Route::get('filterable/{start_date?}{end_date?}{description?}',[TaskController::class,'filterable']);
});

/**
 * Admin End
 */


/**
 * User
 */
Route::group([
    'middleware' => ['api','auth:api'],
    'prefix' => 'user-task'
], function(){
    //Users All List For Admin
    Route::get('list',[TaskController::class,'getTaskListByEachUser']);
    //Create New Task
    Route::post('create',[TaskController::class,'store']);
    //Remove Task
    Route::post('remove/{tasks}',[TaskController::class,'destroy']);
});

Route::group([
    'middleware' => ['api','auth:api','can:admin'],
    'prefix' => 'user-chance'
], function(){
    //Users All List For Admin
    Route::get('gift',[AllocatedBonusForUser::class,'getUsersBonus']);
});
