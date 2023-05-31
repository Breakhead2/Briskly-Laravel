<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class LessonApiController extends Controller
{
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
