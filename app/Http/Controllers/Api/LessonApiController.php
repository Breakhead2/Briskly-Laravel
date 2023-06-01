<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class LessonApiController extends Controller
{
    public function getLessonsList(Request $request)
    {
        $courseId = $request->input('id');
        $lessons = Article::where('course_id', $courseId)->get();
        $data = [];

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
            $test = Test::find($lesson->id);
            $questions = Question::where('test_id', $test->id)->get();
            $response = [
                "success" => true,
                "lesson" => $lesson,
                "exercise_type" => Exercise::find($lesson->id)->type,
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
