<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLesson;

class LessonApiController extends Controller
{
    public function getLessonsList(Request $request)
    {
        $user = Auth::user();
        $courseId = $request->input('id');
        $lessons = Article::where('course_id', $courseId)->get();
        $data = [];
        $passLessonsArray = [];

        if ($user){
            $passLessons = UserLesson::where("user_id", $user->id)->get();
            if ($passLessons){
                foreach ($passLessons as $passLesson){
                    $passLessonsArray[] = $passLesson->lesson_id;
                }
            }
        }

        if($lessons) {
            foreach ($lessons as $lesson){
                $data[] = [
                    "id" => $lesson->id,
                    "heading" => $lesson->heading,
                    "image" => $lesson->image_url,
                ];
            }

            $response = [
                "success" => true,
                "lessons" => $data,
                "pass_lessons" => $passLessonsArray,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Lessons for this course doesn't exist"
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getLessonData(Request $request)
    {
        $lessonId = $request->input('id');
        $lesson = Article::find($lessonId);

        if($lesson){
            $test = Test::where("article_id", $lesson->id)->first();
            $questions = Question::where('test_id', $test->id)->get();
            $response = [
                "success" => true,
                "lesson" => $lesson,
                "exercise_type" => Exercise::find($lesson->exercise_id)->type,
                "questions" => $questions,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Lesson doesn't exist",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
