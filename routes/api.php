<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'Api\AuthController@login');
Route::get('attendance/dates', 'Api\AttendanceController@dates');
Route::get('attendance/notes', 'Api\AttendanceController@notes');
Route::post('attendance/update', 'Api\AttendanceController@update');
Route::get('group/students', 'Api\GroupController@students');
Route::group([
    'namespace' => 'Api',
    'middleware' => 'auth:api',
], function () {
    Route::get('users', 'UserController@all');
    Route::get('user', 'UserController@info');
    Route::get('user/{id}', 'UserController@userById');

    Route::get('schedule', 'ScheduleController@schedule');

    Route::get('news', 'NewsController@all');
    Route::get('news/{id}', 'NewsController@newsById');

    Route::get('faqs', 'FaqController@all');
    Route::get('faq/{id}', 'FaqController@faqById');

    Route::post('chats', 'ChatController@chats');
    Route::get('chat/{id}', 'ChatController@getById');
    Route::post('chat/{id}/delete', 'ChatController@delete');
    Route::post('chat/send', 'ChatController@send');
    Route::get('my/chat', 'ChatController@myChat');

});
