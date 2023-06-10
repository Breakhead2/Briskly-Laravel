<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    public function getTestsList()
    {
        $tests = Test::where("article_id", null)->get();

        if ($tests) {
            $response = [
                "success" => true,
                "tests" => $tests,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Can't find tests",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getTest(Request $request)
    {
        $testId = $request->input('id');
        $test = Test::find($testId);

        $questions = Question::where("test_id", $testId)->get();

        if ($test && $questions) {
            $response = [
                "success" => true,
                "test_name" => $test->name,
                "article" => $test->article_id,
                "questions" => $questions,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Тест не найден",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
