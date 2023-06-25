<?php

use App\Http\Controllers\Api\LessonApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\TestApiController;
use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProfileApiController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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
Route::get('/get/lesson', [LessonApiController::class, 'getLessonData']);
Route::get('/get/tests', [TestApiController::class, 'getTestsList']);
Route::get('/get/test', [TestApiController::class, 'getTest']);
Route::get('/get/articles', [ArticleApiController::class, 'getArticlesList']);
Route::get('/get/article', [ArticleApiController::class, 'getArticle']);
Route::get('/get/slides', [SliderApiController::class, 'getSlides']);

Route::get('/send/mail', [SendMailController::class, 'sendNotification']);

// auth
Route::post('/auth/register', [RegisterController::class, 'create']);
Route::post('/auth/login', [LoginController::class, 'auth']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get/user', [UserApiController::class, 'getUser']);
    Route::get('/auth/logout', [LoginController::class, 'logout']);
    Route::get('/get/profile', [ProfileApiController::class, 'getProfile']);
    Route::get('/send/points', [ProfileApiController::class, 'sendPoints']);
    Route::get('/get/lessons', [LessonApiController::class, 'getLessonsList']);
    Route::post('/send/words', [ProfileApiController::class, 'storeWords']);
});


