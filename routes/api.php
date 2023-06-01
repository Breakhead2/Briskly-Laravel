<?php

use App\Http\Controllers\Api\LessonApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\CourseApiController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/get/courses', [CourseApiController::class, 'getCoursesList']);
Route::get('/get/lessons', [LessonApiController::class, 'getLessonsList']);
Route::get('/get/lesson', [LessonApiController::class, 'getLessonData']);
Route::get('/get/slides', [SliderApiController::class, 'getSlides']);
